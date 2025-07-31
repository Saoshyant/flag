import { importantText, Button } from "./modules.js";

console.log(importantText);

const btn = new Button();

const pageBtn = document.getElementById("pageBtn");

pageBtn.addEventListener("click", btn.click );
