
# json is in the standard library as of python 2.6; fall back to
# simplejson if present for older versions.
try:
  import json
  assert hasattr(json, "dumps")
  _json_encode = lambda v: json.dumps(v)
except:
  try:
    import simplejson
    _json_encode = lambda v: simplejson.dumps(v)
  except ImportError:
    try:
      # For Google AppEngine
      from django.utils import simplejson
      _json_encode = lambda v: simplejson.dumps(v)
    except ImportError:
      raise NotImplementedError(
        "A JSON parser is required, e.g., simplejson at "
        "http://pypi.python.org/pypi/simplejson/")

import re

VALID_EMAIL = re.compile(r'^.+@.+\..+$')

class Performable(object):
  """
    Example Usage:
      x = Performable('XXXXXX')
      x.identify(id='123456', email='jane@performable.com')
      print x
  """

  def __init__(self, account):
    self.account = account
    self.identity = {}

  def identify(self, **kwargs):
    """ you should use one or more arguments such as:
      id - a stable internal user id
      email - user's email address
      facebook_id or facebook (for the username)
      twitter_id or twitter (for the username)

    e.g. x.identify(id='XYZ', twitter='eliast')
    """
    if 'email' in kwargs:
      if not VALID_EMAIL.match(kwargs.get('email')):
        del kwargs['email']

    self.identity.update(kwargs)

  def __str__(self):
    lines = []
    if self.identity:
      lines.append('<script type="text/javascript">')
      lines.append('var _paq = _paq || [];')
      lines.append('_paq.push(["identify", %s])' % _json_encode(self.identity))
      lines.append('</script>')
    lines.append('<script src="//d1nu2rn22elx8m.cloudfront.net/performable/pax/%s.js"></script>' % self.account)
    return '\n'.join(lines)


