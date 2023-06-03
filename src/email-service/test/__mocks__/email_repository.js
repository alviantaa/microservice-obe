import entities from "../../src/db/mongo/entities/index.js";
import * as constants from "../../src/constants/index.js";
import mongoose from "mongoose";

const getById = jest.fn((id) => {
  // list of emails (array)
  let emailList = [
    new entities.Email({
      to: ["test@gmail.com"],
      cc: [],
      bcc: [],
      subject: [],
      from: ["from@gmail.com"],
      text: "hi from test!",
      status: constants.EMAIL_STATUS_NOT_SENT,
      createdAt: Date.now(),
      _id: "617cfa4c9e3f7a001f9a63fd",
    }),
  ];

  // search through array
  for (const element of emailList) {
    if (element._id.toString() === id) {
      return Promise.resolve(element);
    }
  }
  return Promise.resolve(null);
});

const create = jest.fn(async (emailEntity) => {
  const email = new entities.Email({
    to: emailEntity.to,
    cc: emailEntity.cc,
    bcc: emailEntity.bcc,
    subject: emailEntity.subject,

    text: emailEntity.text,
    html: emailEntity.html,
    attachments: emailEntity.attachments,

    // array of emails the email was successfully delivered.
    accepted: emailEntity.accepted,

    // array of emails which the delivery was rejected.
    rejected: emailEntity.rejected,

    // A unique identifier assigned to the email message
    messageId: emailEntity.messageId,

    status: emailEntity.status,
  });
  await email.validate();
  return { acknowledged: true, insertedId: new mongoose.Types.ObjectId() };
});

export default {
  getById,
  create,
};
