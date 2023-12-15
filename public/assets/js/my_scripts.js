// function convert number to rupiah
function formatRupiah(angka, prefix) {
    var number_string = angka.replaceAll(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
}

// function convert input selling price to format rupiah
const convertRupiah = (selector) => {
    var sellingPrice = document.getElementById(selector);
    sellingPrice.addEventListener('keyup', function (e) {
        sellingPrice.value = formatRupiah(this.value, 'Rp ');
    });
}

// function to set tinymce
const setTinyMce = (mode, selector, read) => {
    tinymce.remove();
    var options = {
        selector: selector, height: "240", plugins: "advlist autolink link lists preview code",
        toolbar: ["styleselect fontselect fontsizeselect | undo redo | bold italic | link | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent"],
        readonly: read
    };

    if (mode === "dark") {
        options["skin"] = "oxide-dark";
        options["content_css"] = "dark";
    }

    tinymce.init(options);
}