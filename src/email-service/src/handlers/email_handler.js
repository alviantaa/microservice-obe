import httpcode from "http-status-codes";

import config from "../config/index.js";
import * as dto from "../dto/index.js";
import * as api_res from "../sdk/api_res/api_res.js";
import EmailService from "../services/email_service.js";

const emailService = new EmailService();
/*
 *  @description handler that doesn't actually send email,
 *  made for customer to check email's content
 */
export async function sendEmailDebug(req, res) {
  let payload = new dto.emailDto.SendEmailRequest(req.body, req.files);

  let { error } = payload.validate();
  if (error) {
    return api_res.failOrError(res, httpcode.BAD_REQUEST, error.message);
  }

  // template engine (body + data)
  if (payload.data) {
    if (payload.text)
      payload.text = emailService.compileTemplate(payload.text, payload.data);
    if (payload.html)
      payload.html = emailService.compileTemplate(payload.html, payload.data);
  }
  //---

  let email = {
    to: payload.to,
    cc: payload.cc,
    bcc: payload.bcc,
    from: config.mailFrom0,
    subject: payload.subject,
    text: payload.text,
    html: payload.html,
    attachments: payload.attachments,
  };
  return api_res.success(res, httpcode.OK, 'success', { email: email });
}
