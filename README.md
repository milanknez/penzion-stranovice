# Penzion Statek Straňovice - CMS "Baťa" Edition

Tento projekt je lehký, souborově orientovaný CMS postavený na PHP a GrapesJS, navržený pro bleskové nasazování a správu webů bez potřeby databáze.

## Hlavní funkce
- **Žádná databáze**: Veškerý obsah a metadata jsou uloženy v JSON souborech (`config/`).
- **Vizuální editor**: Integrovaný GrapesJS pro drag-and-drop editaci obsahu.
- **Automatický Git**: Každé uložení v administraci automaticky vytvoří commit a pushne změny do repozitáře.
- **SEO URL**: Podpora pro hezké adresy (např. `/kocici-apartman` místo `pokoj.php`).

## Lokální spuštění
Pro správné fungování SEO adres na vestavěném PHP serveru spouštějte projekt příkazem:
```bash
php -S localhost:8002 router.php
```

## Konfigurace serveru (Deployment)

### Apache
V kořenovém adresáři je připraven soubor `.htaccess`, který automaticky přesměruje požadavky na `router.php`. Ujistěte se, že máte povolen `mod_rewrite`.

### Nginx
Do konfiguračního souboru vaší site přidejte následující pravidlo do sekce `location /`:
```nginx
location / {
    try_files $uri $uri/ /router.php?$query_string;
}
```

## Nastavení Gitu a Tokenu
V souboru `admin/config.php` nastavte přístupové údaje:
- `REPO_URL`: Adresa vašeho GitHub repozitáře.
- `GITHUB_TOKEN`: Váš Personal Access Token (PAT) pro automatický push bez hesla.

## Správa Metadat
V administraci klikněte na tlačítko **"NASTAVENÍ STRÁNKY"**. Zde můžete upravovat:
- **URL Slug**: Adresa stránky (např. `o-nas`).
- **SEO Titulek**: Zobrazuje se v záložce prohlížeče.
- **SEO Popis**: Důležité pro Google výsledky vyhledávání.

Všechna tato data se ukládají do `config/pages.json`.

## Automatický Deploy (GitHub Actions)
Projekt obsahuje konfiguraci pro automatický deploy přes SSH. Aby fungoval, nastavte v nastavení repozitáře (Settings -> Secrets and variables -> Actions) tyto tajné klíče:
- `SERVER_HOST`: IP adresa nebo doména vašeho serveru.
- `SERVER_USER`: Uživatelské jméno (např. `www-data` nebo `root`).
- `SERVER_SSH_KEY`: Váš soukromý SSH klíč (private key), který má přístup k serveru.

Workflow najdete v `.github/workflows/deploy.yml`.

---
Vytvořeno s ❤️ pro rychlou tvorbu webů.
