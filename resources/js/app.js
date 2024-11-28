import './bootstrap';

(function ($) {
    "use strict";

    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });

})(jQuery);

document.addEventListener('DOMContentLoaded', function () {
    // Selecciona los elementos
    const institutionSelect = document.getElementById('institutionId');
    const buildingSelect = document.getElementById('buildingId');
    const floorSelect = document.getElementById('floorSelect');

    // Función para obtener edificios cuando se selecciona una institución
    institutionSelect.addEventListener('change', function () {
        const institutionId = this.value;

        // Limpiar los selectores de edificios y pisos antes de llenarlos
        buildingSelect.innerHTML = '<option value="">Seleccione un edificio</option>';
        floorSelect.innerHTML = '<option value="">Seleccione un piso</option>';

        if (institutionId) {
            // Hacer la solicitud AJAX para obtener los edificios de la institución seleccionada
            fetch(`/get-buildings/${institutionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.buildings && data.buildings.length) {
                        // Llenar el selector de edificios
                        data.buildings.forEach(building => {
                            const option = document.createElement('option');
                            option.value = building.id;
                            option.textContent = building.name;
                            buildingSelect.appendChild(option);
                        });
                    }
                });
        }
    });

    // Función para obtener pisos cuando se selecciona un edificio
    buildingSelect.addEventListener('change', function () {
        const buildingId = this.value;

        // Limpiar el selector de pisos antes de llenarlo
        floorSelect.innerHTML = '<option value="">Seleccione un piso</option>';

        if (buildingId) {
            // Hacer la solicitud AJAX para obtener los pisos del edificio seleccionado
            fetch(`/get-floors/${buildingId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.floors && data.floors.length) {
                        // Llenar el selector de pisos
                        data.floors.forEach(floor => {
                            const option = document.createElement('option');
                            option.value = floor;
                            option.textContent = `Piso ${floor}`;
                            floorSelect.appendChild(option);
                        });
                    }
                });
        }
    });
});
