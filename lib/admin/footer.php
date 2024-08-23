<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecting the header checkbox
        const checkAll = document.getElementById('checkAll');

        // Selecting all checkboxes in the table body
        const checkboxes = document.querySelectorAll('.item-checkbox');

        // Adding event listener to the header checkbox
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
            });
        });

        // Adding event listeners to individual checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // If any individual checkbox is unchecked, uncheck the header checkbox
                if (!this.checked) {
                    checkAll.checked = false;
                } else {
                    // Check if all checkboxes are checked to enable the header checkbox
                    checkAll.checked = [...checkboxes].every(checkbox => checkbox.checked);
                }
            });
        });
    });

    // PRODUK MULTIPLE
    const thumbnailFile = document.getElementById('thumbnail');
    const imagesFile = document.getElementById('images');
    const listimage = document.getElementById('list-images');
    const removeList = document.querySelectorAll('#remove-list');
    
    document.addEventListener('DOMContentLoaded', function() {
        imagesFile.addEventListener('change', function(e) {
            e.preventDefault();
            const imageFiles = e.target.files;
            listimage.innerHTML = '';
            for (let index = 0; index < imageFiles.length; index++) {
                const reader = new FileReader();
                reader.readAsDataURL(imageFiles[index]);
                reader.addEventListener('load', () => {
                    const img = `
                    <div class="item position-relative" data-item="${index + 1}" style="width: max-content;">
                        <img id="displayimg" class="rounded-2" src="${reader.result}" width="116" height="118" alt="" srcset="">
                        <span data-img="${index + 1}" id="remove-list" class="remove-list position-absolute top-0 start-100 translate-middle badge border border-light border-2 rounded-circle bg-danger" style="z-index: 1">X</span>
                    </div>`;
                    listimage.insertAdjacentHTML('beforeend', img);
                });
            }
        });
    
        listimage.addEventListener('click', function(e) {
            if (e.target.id === 'remove-list') {
                const elemData = e.target.dataset.img;
                if (elemData) {
                    if (confirm("Delete images?")) {
                        listimage.removeChild(e.target.parentElement);
                    }
                }
            }
        });
    });
</script>

</html>