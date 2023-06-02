import entities from "../db/mongo/entities/index.js";
import * as constants from "../constants/index.js";

/*
 * @throws {Error} Throws an error if the operation fails
 */
export async function create(emailEntity) {
  entities.Email.create({
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
}
