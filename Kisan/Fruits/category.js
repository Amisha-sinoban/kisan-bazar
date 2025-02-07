document.addEventListener('DOMContentLoaded', () => {
    const categories = document.querySelectorAll ('.category');
    const subtypes = document.querySelectorAll('.subtypes li');

    categories.forEach(category => {
        category.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent closing when clicking on the category
            const dropdown = category.querySelector('.dropdown-content');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-content').forEach(dd => {
                if (dd !== dropdown) {
                    dd.style.display = 'none';
                }
            });
        });
    });

    subtypes.forEach(subtype => {
        subtype.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent the category click event from firing
            const subcategories = subtype.querySelector('.subcategories');
            subcategories.style.display = subcategories.style.display === 'block' ? 'none' : 'block';
            // Close all other subcategories
            document.querySelectorAll('.subcategories').forEach(sc => {
                if (sc !== subcategories) {
                    sc.style.display = 'none';
                }
            });
        });
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-content').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
        document.querySelectorAll('.subcategories').forEach(subcategory => {
            subcategory.style.display = 'none';
        });
    });
});