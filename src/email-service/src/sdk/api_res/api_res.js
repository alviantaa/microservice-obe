/*
 *   response mainly consist of these 3 fields:
 *   1. status (string, 'success'/'fail'/'error') required
 *   2. message (string) required
 *   3. data (any) optional
 */

import * as constants from "../../constants/index.js";

export function success(res, statusCode, message, data) {
  return res.status(statusCode).json({
    status: constants.STATUS_SUCCESS,
    message: message || "successfully processed your request :)",
    data: data,
  });
}

export function failOrError(res, statusCode, message, data) {
  // TODO: LOGGER (if error only?)
  // 4xx means fail, 5xx or else means error
  const status =
    statusCode.toString()[0] === "4"
      ? constants.STATUS_FAIL
      : constants.STATUS_ERROR;

  return res.status(statusCode).json({
    status: status,
    message: message || "failed to process your request :(",
    data: data,
  });
}
