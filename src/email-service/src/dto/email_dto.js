import Joi from "joi";
import * as general_dto from "./general_dto.js";


export class SendEmailRequest {
  // req.body
  to;
  cc;
  bcc;
  subject;


  // the body contains 2 type, text & html
  text;
  html;


  data;
  attachments; //req.files


  constructor(data, files) {
    if (!data || !files) return;
    this.to = data.to;
    this.cc = data.cc;
    this.bcc = data.bcc;
    this.subject = data.subject;
    this.text = data.text;
    this.html = data.html;
    this.data = data.data;


    /*  note:
     *  files comes from req.body which is an array of object
     *  each object typically consists of these fields:
     *  fieldname, originalName (filename), encoding, mimetype & buffer.
     */
    if (Array.isArray(files)) {
      this.attachments = Array();


      files.forEach((file) => {
        // if size > 25megabytes, then skip
        if (file.size > 25 * 1024 * 1024) return;


        // read from BUFFER (other source? not yet implemented)
        // only accept files from these field/s:
        switch (file.fieldname) {
          case "attachments": //attachments is an array
            let newFile = {
              filename: file.originalname || undefined,
              content: file.buffer || undefined,
            };
            this.attachments.push(newFile);
            break;


          default:
            break;
        }
      });


      if (this.attachments.length === 0) {
        this.attachments = undefined;
      }
    }
  }


  static emailToArraySchema = Joi.alternatives(
    Joi.custom((value, helper) => {
      let { error } = Joi.string().email().validate(value);


      if (error) {
        return helpers.message("any.string");
      }
      value = [value]; // to array so it's consistent
      return value;
    }),


    Joi.array().items(Joi.string().email())
  );


  static schema = Joi.object({
    to: SendEmailRequest.emailToArraySchema.required(),


    cc: SendEmailRequest.emailToArraySchema.optional(),


    bcc: SendEmailRequest.emailToArraySchema.optional(),


    subject: Joi.string().required(),


    html: Joi.string().optional(),
    text: Joi.string().optional(),


    attachments: Joi.array()
      .items(
        Joi.object({
          filename: Joi.string().required(),
          content: Joi.binary().required(),
        })
      )
      .optional(),


    data: Joi.optional().custom((value, helpers) => {
      let dataMap;
      try {
        dataMap = JSON.parse(value);
        if (!(typeof dataMap === "object")) {
          throw new Error("JSON sent in 'data' field must be a map.");
        }
      } catch (error) {
        return helpers.message("error while parsing 'data': " + error);
      }
      return dataMap;
    }),
  });


  validate(...options) {
    // validation == {error, value}
    let validation = SendEmailRequest.schema.validate(this, options);
    if (validation.error) {
      return validation;
    }
    this.data = validation.value.data; //string -> object
    this.to = validation.value.to;
    this.cc = validation.value.cc;
    this.bcc = validation.value.bcc;


    return validation;
  }
}

