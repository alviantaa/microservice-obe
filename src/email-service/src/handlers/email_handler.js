import httpcode from "http-status-codes";

import config from "../config/index.js";
import * as dto from "../dto/index.js";
import * as api_res from "../sdk/api_res/api_res.js";
import EmailService from "../services/email_service.js";

const emailService = new EmailService();

/*
 *  @description for sending email and creating the record in db.
 */
export async function sendEmail(req, res) {
  let payload = new dto.emailDto.SendEmailRequest(req.body, req.files);

  let { error } = payload.validate();
  if (error) {
    return api_res.failOrError(res, httpcode.BAD_REQUEST, error.message);
  }

  let info;
  try {
    info = await emailService.sendEmail(
      payload.to,
      payload.cc,
      payload.bcc,
      payload.subject,
      payload.text,
      payload.html,
      payload.attachments,
      payload.data
    );
  } catch (error) {
    return api_res.failOrError(res, error.code, error.message);
  }

  return api_res.success(res, httpcode.OK, "email sent", info);
}

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
  return api_res.success(res, httpcode.OK, "success", { email: email });
}

/*
 *  @description handler for getting emails &
 *  search email (currently by subject only)
 */
export async function getEmails(req, res) {
  // set pagination within constructor
  let payload = new dto.emailDto.getEmailsRequest(
    req.query.limit,
    req.query.page,
    req.query.search
  );

  // validation
  let { error } = payload.validate();
  if (error) {
    return api_res.failOrError(
      res,
      httpcode.BAD_REQUEST,
      "bad request" + error.message
    );
  }

  let emails;
  try {
    let result = await emailService.getEmails(
      payload.pagination.limit,
      payload.pagination.skip,
      payload.search
    );

    emails = result.emails;
    payload.pagination.processPagination(result.totalElement);
  } catch (error) {
    return api_res.failOrError(res, error.code, "fail, server error");
  }

  // if [], 404
  if (emails.length === 0)
    return api_res.failOrError(res, httpcode.NOT_FOUND, "it's empty in here");

  // success
  const response = new dto.emailDto.getEmailsResponse(emails, payload);
  return api_res.success(res, httpcode.OK, "get emails success", response);
}

/*
 *  @description get email record in db by id
 */
export async function getEmailById(req, res) {
  let payload = new dto.emailDto.IdMongoRequest(req.params.id);

  let { error } = payload.validate();
  if (error) {
    return api_res.failOrError(res, httpcode.BAD_REQUEST, "bad request");
  }

  let email;
  try {
    email = await emailService.getById(payload.id);
  } catch (error) {
    return api_res.failOrError(res, error.code, error.message);
  }

  return api_res.success(res, httpcode.OK, "email found", email);
}

/*
 *  @description delete email record in db by id
 */
export async function deleteEmail(req, res) {
  let payload = new dto.emailDto.IdMongoRequest(req.body.id);

  let { error } = payload.validate();
  if (error) {
    return api_res.failOrError(res, httpcode.BAD_REQUEST, "bad request?");
  }

  try {
    await emailService.deleteById(payload.id);
  } catch (error) {
    return api_res.failOrError(res, error.code, error.message);
  }

  return api_res.success(res, httpcode.OK, "delete success", {});
}
