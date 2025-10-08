import argparse, os, re, csv
from urllib.parse import urljoin, urlparse
import requests
from bs4 import BeautifulSoup
from markdownify import markdownify as md

def slugify(url):
    path = urlparse(url).path.strip('/')
    return path.replace('/', '_') or 'home'

def get_links(base, html, current_url):
    soup = BeautifulSoup(html, 'html.parser')
    links = set()
    for a in soup.find_all('a', href=True):
        href = a['href']
        if href.startswith('javascript:') or href.startswith('#'):
            continue
        u = urljoin(current_url, href)
        if urlparse(u).netloc == urlparse(base).netloc:
            parts = urlparse(u)
            clean = parts._replace(query='', fragment='').geturl()
            links.add(clean)
    return links

def extract_title_and_article(html):
    soup = BeautifulSoup(html, 'html.parser')
    title = (soup.title.string.strip() if soup.title and soup.title.string else '').strip()
    main = soup.find('article') or soup.find('main') or soup.find(attrs={'role':'main'}) or soup.body or soup
    for sel in ['nav','header','footer','script','style']:
        for tag in main.find_all(sel):
            tag.decompose()
    text_html = str(main)
    return title, text_html, md(text_html)

def crawl(base, limit=300, out_dir='out'):
    seen, q = set(), [base]
    rows = []
    os.makedirs(os.path.join(out_dir, 'html'), exist_ok=True)
    os.makedirs(os.path.join(out_dir, 'md'), exist_ok=True)

    session = requests.Session()
    session.headers['User-Agent'] = 'WixExportBot/1.0'

    while q and len(seen) < limit:
        url = q.pop(0)
        if url in seen: 
            continue
        try:
            r = session.get(url, timeout=20)
            if r.status_code != 200 or 'text/html' not in r.headers.get('Content-Type',''):
                continue
            html = r.text
        except Exception as e:
            continue

        seen.add(url)
        title, html_body, md_body = extract_title_and_article(html)
        s = slugify(url)
        html_path = os.path.join(out_dir, 'html', s + '.html')
        md_path = os.path.join(out_dir, 'md', s + '.md')
        with open(html_path, 'w', encoding='utf-8') as f:
            f.write(html_body)
        with open(md_path, 'w', encoding='utf-8') as f:
            f.write(f'# {title}\n\n' + md_body)

        rows.append({'url': url, 'title': title, 'slug': s, 'html_path': html_path, 'md_path': md_path})

        for link in list(get_links(base, html, url))[:50]:
            if link not in seen and link.startswith(base):
                q.append(link)

    with open(os.path.join(out_dir, 'index.csv'), 'w', newline='', encoding='utf-8') as f:
        w = csv.DictWriter(f, fieldnames=['url','title','slug','html_path','md_path'])
        w.writeheader()
        w.writerows(rows)

if __name__ == '__main__':
    ap = argparse.ArgumentParser()
    ap.add_argument('--base', required=True)
    ap.add_argument('--limit', type=int, default=300)
    ap.add_argument('--out', default='out')
    args = ap.parse_args()
    crawl(args.base.rstrip('/'), args.limit, args.out)
