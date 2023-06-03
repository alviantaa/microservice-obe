import entities from "../../src/db/mongo/entities/index.js";
import * as constants from "../../src/constants/index.js";
import mongoose from "mongoose";

// list of emails (array)
let emailList = [
  new entities.Email({
    to: ["test@gmail.com"],
    cc: [],
    bcc: [],
    subject: "ini subject",
    from: ["from@gmail.com"],
    text: "hi from test!",
    status: constants.EMAIL_STATUS_NOT_SENT,
    createdAt: Date.now(),
    _id: "617cfa4c9e3f7a001f9a63fd",
  }),

  new entities.Email({
    to: ["test@gmail.com"],
    cc: [],
    bcc: [],
    subject: "this will be deleted",
    from: ["from@gmail.com"],
    text: "hi from test!",
    status: constants.EMAIL_STATUS_NOT_SENT,
    createdAt: Date.now(),
    _id: "617cfa4c9e3f7a001f9a63f2",
  }),

  new entities.Email({
    to: ["test@gmail.com"],
    cc: [],
    bcc: [],
    subject: "ini subject",
    from: ["from@gmail.com"],
    text: "hi from test!",
    status: constants.EMAIL_STATUS_SENT,
    createdAt: Date.now(),
    _id: "617cfa4c9e3f7a001f9a63f3",
  }),
];

const getById = jest.fn((id) => {
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

const deleteById = jest.fn((id) => {
  const response = {
    acknowledged: true,
    deletedCount: 0,
  };

  for (let i = 0; i < emailList.length; i++) {
    if (emailList[i]._id.toString() === id) {
      emailList.splice(i, 1);
      response.deletedCount = 1;
      break;
    }
  }

  if (!response.acknowledged) throw new Error("server error, bad connection?");
  return response.deletedCount;
});

const updateToSent = jest.fn((id) => {
  /*
   *  result : {
   *    n: The number of documents matched for the update operation.
   *    nModified: The number of documents modified during the update operation.
   *    ok: A boolean value indicating if the update operation was successful.
   *  }
   */
  const result = { n: 0, nModified: 0, ok: false };
  for (let i = 0; i < emailList.length; i++) {
    if (emailList[i]._id.toString() === id) {
      emailList[i].status = constants.SENT;
      result.n = result.nModified = 1;
      result.ok = true;
      break;
    }
  }
  return result;
});

export default {
  getById,
  create,
  deleteById,
  updateToSent,
};
