$("a.return-btn").click(function(e){
    e.preventDefault();
    var parent = $(this).closest("tr"),
    qty = parseInt(parent.find(".qty-placeholder").text()),
    barang = parent.find(".nama-placeholder").text(),
    id = parent.find(".id-placeholder").text();
    nilai = 0;

    Swal.fire({
      title: 'Pengembalian',
      text: barang,
      input: 'number',
      inputAttributes: {
        autocapitalize: 'off',
        min: "1",
        max: qty,
        value: "1"
      },
      showCancelButton: true,
      confirmButtonText: 'Simpan',
      showLoaderOnConfirm: true,
      preConfirm: (inputValue) => {
        return fetch(`public/administrator/Pengembalian/create_action?id=` + id + `&qty=${inputValue}`)
          .then(response => {
            if (!response.ok) {
              throw new Error(response.statusText)
            }
            nilai = inputValue;
            return true;
          })
          .catch(error => {
            Swal.showValidationMessage(
              `Request failed: ${error}`
            )
          })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Berhasil menyimpan data",
        });
        
        parent.find(".qty-placeholder").text(qty - nilai);
        if (qty - nilai <= 0){
          $(this).remove();
        }
      }
    })
})