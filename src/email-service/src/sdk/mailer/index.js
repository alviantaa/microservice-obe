/*
 *  TODO:
 *  env & file ini bisa diedit
 *  biar bisa pilih-pilih field "from" email
 */

import nodemailer from 'nodemailer';
import config from '../../config/index.js';

const transport = nodemailer.createTransport({
  host: config.mailHost,
  port: config.mailPort,
  auth: {
    user: config.mailUsername,
    pass: config.mailPassword,
  },
});

export default { transport };
