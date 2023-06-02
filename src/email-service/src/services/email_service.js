import httpcode from 'http-status-codes';
import handlebars from 'handlebars';

import config from '../config/index.js';
import mailer from '../sdk/mailer/index.js';
import Errors from '../sdk/errors/errors.js';

export default class EmailService {
  constructor() {}
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
