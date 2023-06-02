import httpcode from "http-status-codes";
import handlebars from "handlebars";

import config from "../config/index.js";
import mailer from "../sdk/mailer/index.js";
import Errors from "../sdk/errors/errors.js";
import * as constants from "../constants/index.js";
import * as emailrepo from "../repositories/email_repository.js";

export default class EmailService {
  constructor() {}

  /*
   *    all parameters is required ;) except for data
   *    @throws {Errors}
   */
  async sendEmail(to, cc, bcc, subject, text, html, attachments, data) {
    // template engine
    if (data) {
      try {
        if (text) text = this.compileTemplate(text, data);
        if (html) html = this.compileTemplate(html, data);
      } catch (error) {
        throw new Errors(error.message, httpcode.BAD_REQUEST);
      }
    }

    let email = {
      to: to,
      cc: cc,
      bcc: bcc,
      subject: subject,
      from: config.mailFrom0,

      text: text,
      html: html,
      attachments: attachments,
    };
    // send email
    let info;
    try {
      info = await mailer.transport.sendMail(email);
      email.accepted = info.accepted;
      email.rejected = info.rejected;
      email.messageId = info.messageId;
      email.status = constants.EMAIL_STATUS_SENT;
      emailrepo.create(email); // create the record in db
    } catch (error) {
      // data is expected to be validated first
      throw new Errors(error, httpcode.INTERNAL_SERVER_ERROR);
    }
    return info;
  }

  /*
   *    @throws {Errors}
   */
  compileTemplate(templateText, data) {
    if (data) {
      try {
        const template = handlebars.compile(templateText);
        return template(data);
      } catch (error) {
        throw new Errors(error, httpcode.BAD_REQUEST);
      }
    }
    return templateText;
  }
}
