# Banking Management System

A role-based web banking application built with **PHP, MySQL and JavaScript**. A single master **admin** governs the system, **managers** and **employees** run it day to day, and **customers** bank online.

> **Live demo:** _add your Render URL here after deploying_ · **Source:** this repository
>
> Academic course project (AIUB, CSC3215 Web Technologies), later extended and hardened for deployment. It runs on sample data and is **not a real bank**.

## The four portals

| Portal | Who | What they can do |
|---|---|---|
| **Admin** | One fixed master administrator (no screen can edit or delete this account) | Review manager and employee join applications in full and approve or reject them with a note. Add, update, remove, deactivate and change the role of staff. Reset staff passwords. Create and manage customers, including their photo. Assign tasks. Post news to everyone or to one audience. See system totals, every transaction, manager fund transfers, and a full activity log. |
| **Manager** | Approved by the admin | Dashboard with assigned tasks and news, internal fund transfers to other managers, a personal transaction history, their team, a read-only view of employee applicants, profile and password. |
| **Employee** | Approved by the admin | Search and update customers, open new customer accounts, work the customer request queue (reply, resolve, decline), record cash deposits and withdrawals, see assigned tasks and news. |
| **Customer** | Created by the admin or an employee | Balance and a 30-day in/out summary, transfers with PIN confirmation, saved payees, statements with filters and CSV export, alerts, requests to the bank, news, password and PIN changes. |

## How the pieces fit together

```
 applicant ──applies──▶ Admin reviews ──approves──▶ Manager / Employee account
                                                        │
 customer ──requests──▶ Employee handles ──reply + alert──▶ customer
 customer ◀──cash desk deposit / withdrawal── Employee
 Admin ◀── activity log, transactions, tasks, news ── everything above
```

## Highlights

- **Separate sessions per portal**, so a signed-in manager can never open an admin page.
- **Atomic money movement.** Customer transfers and manager fund transfers each run in one database transaction with row locking, per-account balances, overdraft and negative-amount protection.
- **Credentials are hashed** (bcrypt). Sign-in has CSRF protection and a temporary lockout after repeated failures.
- **All database access uses prepared statements**, including the public "is this username taken?" checks.
- **Strict application validation** (identity, age, password strength, duplicates, real PDF and image files) shared by the manager and employee forms.
- **Full audit trail**: sign-ins, failed sign-ins, approvals, role changes, transfers, cash desk, requests and news are all logged for the admin.
- Responsive light and dark theme shared by all four portals.

## Tech stack

PHP 8.3 (Apache) · MySQL 8 / TiDB Cloud · vanilla JavaScript and AJAX · Docker · Render.
Each portal keeps the course's layered layout (controllers, views, scripts); shared data access, validation and helpers live in `config/`.

## Run it locally

Requires [Docker](https://www.docker.com/products/docker-desktop/).

```bash
git clone https://github.com/aftabrakinsad/Banking-Managment-System.git
cd Banking-Managment-System
docker compose up --build
```

Open <http://localhost:8080>. The first start creates the database and loads the demo data. To reset it to a clean state:

```bash
docker compose down -v && docker compose up --build
```

**Demo accounts** (password for all: `Demo@1234`)

| Portal | Username | Notes |
|---|---|---|
| Admin | `admin` | Two applications are waiting for review |
| Manager | `manager` | |
| Employee | `employee` | |
| Customer | `casey`, `riley` | Transfer PINs `1111` and `2222` |

## Deploy (Render + TiDB Cloud)

The web app runs on **Render** (Docker) and the database on **TiDB Cloud Serverless** (MySQL-compatible, free tier). Vercel cannot run PHP, which is why Render is used.

1. **Create the database.** In TiDB Cloud create a Serverless cluster, then a database named `bankingmanagementsystem`. From the cluster's *Connect* dialog note the host, port (4000), user and password.
2. **Load the schema** from your machine through Docker. This needs no MySQL client:
   ```bash
   docker compose run --build --rm --no-deps \
     -e DB_HOST=<host> -e DB_PORT=4000 -e DB_USER=<user> -e DB_PASS=<password> \
     -e DB_NAME=bankingmanagementsystem -e DB_SSL=1 \
     web php /opt/scripts/db_init.php
   ```
   Add `-e MASTER_ADMIN_PASSWORD='something private'` to replace the public demo admin password. Use `--reset --yes` after the script name to wipe and reload.
3. **Create the Render service.** On Render choose *New → Blueprint*, select this repository (`render.yaml` configures everything), and enter `DB_HOST`, `DB_USER`, `DB_PASS` and `DB_NAME` when asked.
4. Open the Render URL, sign in as each role, and put the URL at the top of this README.

### Configuration

| Variable | Purpose |
|---|---|
| `DB_HOST` `DB_PORT` `DB_USER` `DB_PASS` `DB_NAME` | Database connection |
| `DB_SSL=1` | Require TLS (needed by hosted MySQL). `DB_SSL_VERIFY=0` only if a certificate chain cannot be verified |
| `APP_ENV=production` | Secure cookies, hidden PHP version, real client IP in the activity log |
| `APP_DEMO=0` | Hide the demo credentials on the sign-in pages and the landing page |

## Known limitations

- **Uploaded files are not persistent on Render's free tier.** CVs and photos are stored on the container's disk and disappear when the service restarts or redeploys. A production setup would use object storage (S3, Cloudinary).
- **Free services sleep.** The first request after a period of inactivity can take about 30 seconds.
- **The demo is public.** Anyone can sign in with the demo credentials and change data. Reload the database with `db_init.php --reset --yes` to restore it, or set `APP_DEMO=0` and a private `MASTER_ADMIN_PASSWORD`.
- Email-based password reset is not provided. The admin resets staff passwords, and customers use their Security page.
- No automated test suite yet; the application was verified by running the real pages against an emulated database.

## Repository layout

```
Banking Managment System/   web root
  Admin/ Manager/ Employee/ User/   one folder per portal (Control, View, JS; Model where used)
  config/                   shared database, helpers, repositories, validation (not web-accessible)
  assets/theme.css          shared design system
  index.php                 public landing page
db/init/                    schema and demo data (loaded automatically by docker compose)
scripts/db_init.php         loads the schema into any MySQL-compatible database
docker/                     PHP and Apache configuration
render.yaml                 Render blueprint
docs/                       original course proposal and reports
```

## Academic context and credits

Built for **CSC3215 Web Technologies** at the American International University-Bangladesh, Section L. The original four-person team and their modules:

- [Rakin Sad Aftab](https://github.com/aftabrakinsad): Admin
- [Sajid Ibna Mahbub](https://github.com/sajidmahbub10): Manager
- [Sultanul Arifeen Hamim](https://github.com/Arifeenhamim): Employee
- [Tahamidul Haque](https://github.com/tahmid888): User (the customer portal was not in the submitted repository and was rebuilt)

The deployment work reorganised the system around a single master admin, unified the three separate databases into one schema, added the customer portal, and replaced the original authentication, transfer and upload code. The original reports are in `docs/`.

Released under the license in `LICENSE`.
