# AURA secure authentication setup (XAMPP)

This branch adds server-side wallet proof, passcode hashing, session locking, and default-deny API authorization. It is **not verified in the user's local XAMPP environment yet**.

## Required one-time setup

1. Back up the `x_money` database in phpMyAdmin.
2. Ensure the existing Register migration has been applied: `BKD/26.10.00/SQL/register_user_migration.sql`.
3. Run `BKD/26.10.00/SQL/aura_auth_migration.sql` once against the `x_money` database. Do not rerun an `ADD COLUMN` migration after it succeeds.
4. In a terminal opened at `C:\\xampp\\htdocs\\x.moneyy`, run `composer install`.
5. In XAMPP's active PHP configuration, enable the `gmp` extension and restart Apache. Confirm with `php -m` in the same PHP runtime Apache uses; CLI and Apache PHP configurations can differ.
6. Confirm the frontend is configured to use the local PHP API, normally `/x.moneyy/` through the existing Vite proxy when running on localhost.
7. If the frontend and backend are hosted on different HTTPS sites, set `AURA_SESSION_SAMESITE=None`, `AURA_ALLOWED_ORIGINS` to the exact frontend origin(s), and keep HTTPS enabled. Never use wildcard origins with credentialed requests.

## New endpoints

- `POST ?api=Nonce`: creates a 5-minute, one-time wallet challenge.
- `POST ?api=VerifySignature`: recovers the signer from an Ethereum `personal_sign` signature and binds the wallet to a PHP session.
- `POST ?api=Register`: creates a row only after wallet ownership has been verified.
- `POST ?api=PasscodeSetup`: stores a `password_hash()` hash in `Coinx_users.passcode_hash`.
- `POST ?api=PasscodeVerify`: uses `password_verify()`, limits a session to five incorrect attempts per 15-minute window, and unlocks the server session after success.
- `GET ?api=Session`: returns the server session state; it does not reveal profile fields while locked.
- `POST ?api=Session` with `action=lock` or `action=logout`: locks or destroys the server session.

## Local smoke-test checklist

- A GET to `?api=Register` should return 405; registration must use POST.
- A wallet challenge must expire after 5 minutes and cannot be replayed.
- A signature from a different wallet must return 401.
- A successful new registration should create one row in `Coinx_users`.
- No passcode is returned by the API; the database should contain a password hash, not the PIN.
- An incorrect PIN must not unlock the dashboard; after five attempts the endpoint should return 429.
- Protected account APIs should return 401 before passcode verification and should only return the signed-in account's data after unlock.
- Lock and logout should revoke dashboard access until the next successful wallet signature/passcode flow.

## Important limitations

- The Ethereum signature recovery path requires Composer dependencies and PHP GMP to be installed in the **Apache PHP runtime**. If either is missing, verification fails closed with 503.
- The migration has not been run against the user's database here.
- No local PHP/browser/phpMyAdmin test has been performed by this remote code change.
- Existing account login is wired to wallet signature + lock/passcode UI, but must be smoke-tested in the local browser before production use.
- Deposit/withdrawal actions remain disabled until the backend exposes authenticated, audited payment-write APIs; do not enable them by simulating success.
