export default class Errors extends Error {
  code;

  constructor(message, code) {
    super(message);
    this.code = code;
  }
}
