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

/*
 *  @throws {Error} Throws an error if the operation fails
 *  @returns {Array} emails, {number} totalElement
 */
export async function getEmails(limit = 10, skip = 0, search) {
  if (search == "" || search == null) search = undefined;

  const pipeline = [];

  if (search) {
    const regexPattern = new RegExp(search, "i");
    pipeline.push({
      $match: {
        $or: [
          { subject: { $regex: regexPattern } },
          { to: { $elemMatch: { $regex: regexPattern } } },
          { cc: { $elemMatch: { $regex: regexPattern } } },
          { bcc: { $elemMatch: { $regex: regexPattern } } },
          { from: { $elemMatch: { $regex: regexPattern } } },
        ],
      },
    });
  }

  pipeline.push({
    $facet: {
      emails: [{ $skip: skip }, { $limit: limit }],
      totalCount: [
        {
          $group: {
            _id: null,
            count: { $sum: 1 },
          },
        },
        {
          $project: {
            _id: 0,
            count: 1,
          },
        },
      ],
    },
  });
  // aggregation aneh :(

  let result = await entities.Email.aggregate(pipeline).exec();
  result = result[0];

  const emails = result.emails;
  let totalElement;
  if (!result.totalCount[0])
    //if doesn't exists, means the count is 0
    totalElement = 0;
  else totalElement = result.totalCount[0].count;

  return {
    emails: emails,
    totalElement: totalElement,
  };
}

/*
 *  @throws {Error} Throws an error if the operation fails
 *  @returns {Number} deletedCount
 */
export async function deleteById(id) {
  const { acknowledged, deletedCount } = await entities.Email.deleteOne({
    _id: id,
  });
  if (!acknowledged) {
    throw new Error("server error, bad connection?");
  }
  return deletedCount;
}

/*
 *  @throws {Error} Throws an error if the operation fails
 *  @returns {entities.Email} deletedCount
 */
export async function getById(id) {
  return await entities.Email.findById(id);
}
