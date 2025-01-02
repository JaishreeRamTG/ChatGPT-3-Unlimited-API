<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MysticxAi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    header {
      text-align: center;
      padding: 20px;
      background-color: #4CAF50;
      color: white;
      font-size: 24px;
    }
    .search-container {
      text-align: center;
      margin: 20px;
    }
    .search-container input[type="text"] {
      padding: 10px;
      width: 300px;
      font-size: 16px;
    }
    .search-container button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }
    .gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      padding: 20px;
    }
    .gallery img {
      width: 200px;
      height: auto;
      border-radius: 5px;
      transition: transform 0.3s;
    }
    .gallery img:hover {
      transform: scale(1.05);
    }
    .pagination {
      text-align: center;
      margin: 20px;
    }
    .pagination button {
      padding: 10px 20px;
      margin: 5px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>MysticxAi</header>
  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Search for images..." />
    <button onclick="searchImages()">Search</button>
  </div>
  <div id="gallery" class="gallery"></div>
  <div id="pagination" class="pagination"></div>

  <script>
    let currentPage = 1;
    let totalPages = 1;
    let currentQuery = "";

    async function fetchImages(query, page) {
      const apiKey = "20771822-0655996b02b357ba51617fa76";
      const url = `https://pixabay.com/api/?key=${apiKey}&q=${query}&per_page=5&page=${page}`;
      const response = await fetch(url);
      const data = await response.json();
      return data;
    }

    async function searchImages() {
      const query = document.getElementById("searchInput").value.trim();
      if (!query) return;

      currentQuery = query;
      currentPage = 1;
      await loadImages(query, currentPage);
    }

    async function loadImages(query, page) {
      const data = await fetchImages(query, page);

      // Render images
      const gallery = document.getElementById("gallery");
      gallery.innerHTML = "";
      data.hits.forEach((hit) => {
        const img = document.createElement("img");
        img.src = hit.previewURL;
        img.alt = hit.tags;
        img.onclick = () => window.open(hit.pageURL, "_blank");
        gallery.appendChild(img);
      });

      // Setup pagination
      totalPages = Math.ceil(data.totalHits / 5);
      renderPagination();
    }

    function renderPagination() {
      const pagination = document.getElementById("pagination");
      pagination.innerHTML = "";

      if (currentPage > 1) {
        const prevButton = document.createElement("button");
        prevButton.textContent = "Previous";
        prevButton.onclick = () => changePage(currentPage - 1);
        pagination.appendChild(prevButton);
      }

      if (currentPage < totalPages) {
        const nextButton = document.createElement("button");
        nextButton.textContent = "Next";
        nextButton.onclick = () => changePage(currentPage + 1);
        pagination.appendChild(nextButton);
      }
    }

    async function changePage(page) {
      currentPage = page;
      await loadImages(currentQuery, currentPage);
    }
  </script>
</body>
</html>
