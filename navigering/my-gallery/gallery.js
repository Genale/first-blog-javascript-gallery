let images;

$.getJSON("images.json", function (json) {
  images = json;
  addImagesToGalleryAndCreatePopups();
});

function addImagesToGalleryAndCreatePopups() {
  let sintraImages = [images[0], images[1], images[2]];
  let londonImages = [images[3], images[4], images[5]];
  let ugandaImages = [images[6], images[7], images[8]];

  // Array som innehåller alla country-div:ar
  let countryElements = document.getElementsByClassName("country");

  // Loopa igenom sintraImages och lägg in dem i countryElements[0]
  let sintraImagesElement = countryElements[0];
  let londonImagesElement = countryElements[1];
  let ugandaImagesElement = countryElements[2];

  for (image of sintraImages) {
    let titleImageContainer = document.createElement("div");
    titleImageContainer.classList.add("title-image");

    let imageElement = document.createElement("img");
    imageElement.src = image.url;
    imageElement.alt = image.alt;

    let titleElement = document.createElement("p");
    titleElement.innerText = image.title;

    titleImageContainer.appendChild(imageElement);
    titleImageContainer.appendChild(titleElement);

    sintraImagesElement.appendChild(titleImageContainer);
  }

  for (image of londonImages) {
    let titleImageContainer = document.createElement("div");
    titleImageContainer.classList.add("title-image");

    let imageElement = document.createElement("img");
    imageElement.src = image.url;
    imageElement.alt = image.alt;

    let titleElement = document.createElement("p");
    titleElement.innerText = image.title;

    titleImageContainer.appendChild(imageElement);
    titleImageContainer.appendChild(titleElement);

    londonImagesElement.appendChild(titleImageContainer);
  }

  for (image of ugandaImages) {
    let titleImageContainer = document.createElement("div");
    titleImageContainer.classList.add("title-image");

    let imageElement = document.createElement("img");
    imageElement.src = image.url;
    imageElement.alt = image.alt;

    let titleElement = document.createElement("p");
    titleElement.innerText = image.title;

    titleImageContainer.appendChild(imageElement);
    titleImageContainer.appendChild(titleElement);

    ugandaImagesElement.appendChild(titleImageContainer);
  }

  let titleImages = document.querySelectorAll(".title-image");
  for (i = 0; i < titleImages.length; i++) {
    let image = images[i];
    let titleImageElement = titleImages[i];

    titleImageElement.addEventListener("click", () => showImagePopup(image));
  }

  let dialogEl = document.querySelector("#dialog");
  let closeButton = document.querySelector("#close-button");
  closeButton.addEventListener("click", (event) => {
    event.preventDefault();
    dialogEl.hidden = true;
  });
}

function showImagePopup(image) {
  let dialogEl = document.querySelector("#dialog");
  let dialogImage = dialogEl.querySelector("#dialogImage");
  dialogImage.src = image.url;
  dialogEl.hidden = false;
  let imageDescription = dialogEl.querySelector("#imageDescription");
  imageDescription.innerHTML = image.description;
}
