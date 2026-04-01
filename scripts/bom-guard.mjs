#!/usr/bin/env node
import { promises as fs } from "node:fs";
import path from "node:path";

const ROOT = process.cwd();
const FIX = process.argv.includes("--fix");

const SCAN_EXTENSIONS = new Set([
  ".php",
  ".css",
  ".js",
  ".mjs",
  ".json",
  ".md",
]);

const SKIP_DIRS = new Set([
  ".git",
  "node_modules",
  ".vscode",
]);

async function walk(dir, files = []) {
  const entries = await fs.readdir(dir, { withFileTypes: true });

  for (const entry of entries) {
    const fullPath = path.join(dir, entry.name);

    if (entry.isDirectory()) {
      if (!SKIP_DIRS.has(entry.name)) {
        await walk(fullPath, files);
      }
      continue;
    }

    if (!entry.isFile()) {
      continue;
    }

    const ext = path.extname(entry.name).toLowerCase();
    if (SCAN_EXTENSIONS.has(ext)) {
      files.push(fullPath);
    }
  }

  return files;
}

function hasUtf8Bom(buffer) {
  return (
    buffer.length >= 3 &&
    buffer[0] === 0xef &&
    buffer[1] === 0xbb &&
    buffer[2] === 0xbf
  );
}

async function main() {
  const files = await walk(ROOT);
  const offenders = [];

  for (const file of files) {
    const content = await fs.readFile(file);

    if (!hasUtf8Bom(content)) {
      continue;
    }

    offenders.push(file);

    if (FIX) {
      await fs.writeFile(file, content.subarray(3));
    }
  }

  if (!offenders.length) {
    console.log("BOM guard: no UTF-8 BOM found.");
    return;
  }

  const rel = offenders.map((f) => path.relative(ROOT, f));

  if (FIX) {
    console.log("BOM guard: removed UTF-8 BOM from:");
    for (const file of rel) {
      console.log(`- ${file}`);
    }
    return;
  }

  console.error("BOM guard: UTF-8 BOM detected in:");
  for (const file of rel) {
    console.error(`- ${file}`);
  }
  console.error("\nRun `pnpm run fix:bom` to remove them automatically.");
  process.exit(1);
}

main().catch((error) => {
  console.error("BOM guard failed:", error);
  process.exit(1);
});

