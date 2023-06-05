import mongoose from "mongoose";
import * as constants from "../../../constants/index.js";

const emailEntity = new mongoose.Schema({
  to: {
    type: [String],
    required: true,
  },
  cc: [String],
  bcc: [String],
  subject: String,
  from: String,

  text: String,
  html: String,
  attachments: Object,

  //array of emails the email was successfully delivered.
  accepted: [String],

  //array of emails which the delivery was rejected.
  rejected: [String],

  //A unique identifier assigned to the email message
  messageId: {
    type: String,
    immutable: true,
  },

  status: {
    type: String,
    enum: [constants.EMAIL_STATUS_SENT, constants.EMAIL_STATUS_NOT_SENT],
    default: constants.EMAIL_STATUS_NOT_SENT,
    required: true,
  },

  createdAt: {
    type: Date,
    immutable: true,
    default: () => Date.now(),
  },

  updatedAt: {
    type: Date,
  },
});

export default mongoose.model("Email", emailEntity);
