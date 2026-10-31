# Client Handover & Production Launch Guide - Pavaki Infra

This document provides a comprehensive summary of implemented features, verified facts used, items requiring owner confirmation, and the step-by-step production launch checklist.

---

## 1. Verified Information Implemented

All information was verified against the official reference site `https://pavakiinfra.com/`:

| Attribute | Verified Value Used in Codebase | Source / Status |
| :--- | :--- | :--- |
| **Brand Name** | **Pavaki Infra** | Verified & Active |
| **Legal Entity** | **Pavaki Infrasolutions LLP** | Verified & Active |
| **Primary Domain** | `pavakiinfra.com` | Verified & Active |
| **Primary Email** | `info@pavakiinfra.com` | Verified & Active |
| **Primary Telephone** | `+91 72087 44092` (Raw: `+917208744092`) | Verified & Active |
| **Registered Office** | `3/466, Vishvas Khand, Gomti Nagar, Lucknow – 226010, INDIA` | Verified & Active |
| **Corporate Office** | `Singh Housing Soc, Singh Sadan, Raghvendra Mandir Road, Mumbai – 400102, INDIA` | Verified & Active |
| **Business Hours** | `Mon – Sat: 09:00 – 18:00 IST` | Verified & Active |
| **Verified Services** | 10 Civil Disciplines (Roadways, Bridges, Railways, Tunnels, Coastal, Buildings, Dams, Piling, Blasting/Excavation, Materials) | Verified & Active |
| **Landmark Projects** | 5 Landmark Projects (Versova-Bandra Sea Link, Samruddhi Mahamarg, Agra Cultural Centre, Ayodhya Shodh Sansthan, Varanasi Solar) | Verified & Active |

---

## 2. Items Requiring Owner Input / Confirmation

The following operational items should be reviewed by the business owner in `config/config.php`:

- [ ] **Mail Server Credentials (`config/config.php` under `'mail'`):**
  - If deploying to a server requiring SMTP authentication, configure `transport => 'smtp'` with the host, username, and password. By default, standard PHP `mail()` and local JSONL logging are enabled.
- [ ] **Optional WhatsApp Contact:**
  - If a dedicated WhatsApp business number is desired for public inquiries, set `business.whatsapp` and `business.whatsapp_raw`. Currently left empty to gracefully omit WhatsApp links until confirmed.
- [ ] **5-Stage Work Process Confirmation:**
  - The standard civil execution workflow (Tender Review -> Site Reconnaissance -> Method Statements -> Managed Execution -> Joint Sign-Off) is implemented in `config/config.php`. Confirm if any internal operational nomenclature should be customized.
- [ ] **Optional Real Project Photographs:**
  - The site includes 5 bespoke architectural vector illustrations matching each verified landmark project. If high-resolution on-site construction photos become available, they can be uploaded to `assets/img/` and referenced in `config/config.php`.
- [ ] **Legal Review of Privacy Notice:**
  - `privacy.php` accurately discloses the server-side form processing, IP rate-limiting, and JSONL log storage. Have your legal counsel review for jurisdictional compliance with Indian IT Act rules.

---

## 3. Production Launch Checklist (Going Live)

Once the owner is ready to deploy publicly:

1. **Enable Site Indexing in `config/config.php`:**
   ```php
   'site_live' => true,
   'base_url'  => 'https://pavakiinfra.com',
   'clean_urls'=> true, // if Apache mod_rewrite is enabled
   ```
2. **Update `robots.txt`:**
   Remove the staging `Disallow: /` and enable:
   ```txt
   User-agent: *
   Allow: /
   Disallow: /config/
   Disallow: /includes/
   Disallow: /storage/
   Disallow: /404.php

   Sitemap: https://pavakiinfra.com/sitemap.xml
   ```
3. **Verify Storage Permissions:**
   Ensure `storage/` directory permissions on your host are set to `0750` or `0755` so the web server can record valid submissions in `storage/submissions.jsonl`.
