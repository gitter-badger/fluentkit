/* */ 
var MATCH = require('./$.wks')('match');
module.exports = function(KEY) {
  var re = /./;
  try {
    '/./'[KEY](re);
  } catch (e) {
    try {
      re[MATCH] = false;
      return !'/./'[KEY](re);
    } catch (f) {}
  }
  return true;
};
