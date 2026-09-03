// Shared reCAPTCHA v3 helper.
// Requires window.RECAPTCHA_SITE_KEY to be set (see components/layouts.blade.php)
// and the Google reCAPTCHA v3 script to already be loaded on the page.

function getRecaptchaToken(action) {
  return new Promise((resolve, reject) => {
    if (!window.grecaptcha || !window.RECAPTCHA_SITE_KEY) {
      // No key configured / script not loaded — resolve with null so the
      // request still goes through server-side (which will reject it if
      // a token is actually required).
      resolve(null);
      return;
    }

    grecaptcha.ready(() => {
      grecaptcha
        .execute(window.RECAPTCHA_SITE_KEY, { action })
        .then(resolve)
        .catch(reject);
    });
  });
}