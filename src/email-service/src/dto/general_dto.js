import Joi from "joi";

export class Pagination {
  limit;
  page;
  totalElement;
  totalPages;

  // set pagination
  constructor(limit, page, maxLimit) {
    this.limit = 1;
    if (limit > 0 && Number.isInteger(parseInt(limit))) {
      if (limit > maxLimit) this.limit = maxLimit;
      else this.limit = limit;
    }

    this.page = 1;
    if (page > 1 && Number.isInteger(parseInt(page))) this.page = page;
  }

  // or so called "offset"
  get skip() {
    return (this.page - 1) * this.limit;
  }

  // process pagination
  processPagination(totalElement) {
    if (Number.isInteger(parseInt(totalElement))) {
      this.totalElement = totalElement;
      this.totalPages = Math.ceil(totalElement / this.limit);
    }
  }

  static schema = Joi.object({
    limit: Joi.number().integer().optional(),
    page: Joi.number().integer().optional(),
  }).unknown(true);

  validate(...options) {
    let info = Pagination.schema.validate(this, ...options);

    this.limit = info.value.limit;
    this.page = info.value.page;

    return info;
  }
}
