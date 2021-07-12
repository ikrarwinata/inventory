function Notify(text, title = ' Uppsss...', type = "success"){
	new PNotify({
		title: title,
		type: type,
		text: text,
		nonblock: {
			nonblock: true
		},
		styling: 'bootstrap3',
	});
}

$("th > input[type=checkbox]").change(function(e){
	var parent = this;
	$("td > input[type=checkbox]").each(function(){
		this.checked = parent.checked;
	})
});

$("#pembelian-barcode-search-btn").click(function(e){
	e.preventDefault();
	let timerInterval;
	Swal.fire({
		title: 'Please wait',
		html: 'Looking for data...',
		timer: 10000,
		timerProgressBar: true,
		didOpen: () => {
			Swal.showLoading()
			timerInterval = setInterval(() => {
				const content = Swal.getContent()
				if (content) {
					const b = content.querySelector('b')
					if (b) {
						b.textContent = Swal.getTimerLeft()
					}
				}
			}, 100)
		},
		willClose: () => {
			clearInterval(timerInterval);
		}
	}).then((result) => {
		/* Read more about handling dismissals below */
		if (result.dismiss === Swal.DismissReason.timer) {
			Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
		}
	});

	var value = $("#barcode.pembelian-ajax").val(), parent = $(this).closest("fieldset");
	
	$.post("public/Api/getAssetByBarcode", { id: value })
		.done(function (data) {
			parent.find("fieldset").remove();
			parent.find("#nama").val("");
			if (data) {
				data = JSON.parse(data);
				parent.find("#nama").val(data.nama);
				$("#harga").val(data.harga);
				$.post("public/Api/getAssetViewBarcode", { id: value })
					.done(function (data) {
						Swal.close();
						parent.append(data);
						parent.find("#selectmethod").val("auto");
						timerInterval = setInterval(() => {
							$("#quantity").focus();
							clearInterval(timerInterval)
						}, 1000);
					});
			}else{
				$.get("public/Api/getAssetViewEmpty")
					.done(function (data) {
						Notify("Data barang tidak ditemukan, silahkan masukan rincian barang secara manual", ' Uppsss...', "warning");
						Swal.close();
						parent.append(data);
						parent.find("#nama").val("");
						parent.find("#selectmethod").val("manual");
					});
			}
		});

	return false;
});

$("#pembelian-nama-search-btn").click(function(e){
	e.preventDefault();
	let timerInterval;
	Swal.fire({
		title: 'Please wait',
		html: 'Looking for data...',
		timer: 10000,
		timerProgressBar: true,
		didOpen: () => {
			Swal.showLoading()
			timerInterval = setInterval(() => {
				const content = Swal.getContent()
				if (content) {
					const b = content.querySelector('b')
					if (b) {
						b.textContent = Swal.getTimerLeft()
					}
				}
			}, 100)
		},
		willClose: () => {
			clearInterval(timerInterval);
		}
	}).then((result) => {
		/* Read more about handling dismissals below */
		if (result.dismiss === Swal.DismissReason.timer) {
			Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
		}
	});

	var value = $("#nama.pembelian-ajax").val(), parent = $(this).closest("fieldset");

	$.post("public/Api/getAssetByName", { id: value })
		.done(function (data) {
			parent.find("fieldset").remove();
			parent.find("#barcode").val("");
			if (data) {
				data = JSON.parse(data);
				parent.find("#barcode").val(data.barcode);
				$("#harga").val(data.harga);
				$.post("public/Api/getAssetViewBarcode", { id: data.barcode })
					.done(function (data2) {
						Swal.close();
						parent.append(data2);
						parent.find("#selectmethod").val("auto");
						timerInterval = setInterval(() => {
							$("#quantity").focus();
							clearInterval(timerInterval);
						}, 1000);
					});
			} else {
				$.get("public/Api/getAssetViewEmpty")
					.done(function (data2) {
						Notify("Data barang tidak ditemukan, silahkan masukan rincian barang secara manual", ' Uppsss...', "warning");
						Swal.close();
						parent.append(data2);
						parent.find("#nama").val("");
						parent.find("#selectmethod").val("manual");
					});
			}
		});

	return false;
});

$("#penjualan-barcode-search-btn").click(function(e){
	e.preventDefault();
	let timerInterval;
	Swal.fire({
		title: 'Please wait',
		html: 'Looking for data...',
		timer: 10000,
		timerProgressBar: true,
		didOpen: () => {
			Swal.showLoading()
			timerInterval = setInterval(() => {
				const content = Swal.getContent()
				if (content) {
					const b = content.querySelector('b')
					if (b) {
						b.textContent = Swal.getTimerLeft()
					}
				}
			}, 100)
		},
		willClose: () => {
			clearInterval(timerInterval);
		}
	}).then((result) => {
		/* Read more about handling dismissals below */
		if (result.dismiss === Swal.DismissReason.timer) {
			Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
		}
	});

	var value = $("#barcode.penjualan-ajax").val(), parent = $(this).closest("fieldset");

	$.post("public/Api/getAssetByBarcode", { id: value })
		.done(function (data) {
			parent.find("fieldset").remove();
			parent.find("#nama").val("");
			if (data) {
				data = JSON.parse(data);
				parent.find("#nama").val(data.nama);
				$("#harga").val(data.harga);
				$("#quantity").attr("max", data.stok);
				if ($("#quantity").val() > data.stok) $("#quantity").val(data.stok);
				$.post("public/Api/getAssetPenjualanViewBarcode", { id: value })
					.done(function (data2) {
						Swal.close();
						parent.append(data2);
						parent.find("#selectmethod").val("auto");
						timerInterval = setInterval(() => {
							$("#quantity").focus();
							clearInterval(timerInterval)
						}, 1000);
					});
			} else {
				parent.find("#selectmethod").val("manual");
				Notify("Data barang tidak ditemukan, pastikan barcode yang kamu masukan sudah benar", ' Uppsss...', "error");
				Swal.close();
			}
		});

	return false;
});

$("#penjualan-nama-search-btn").click(function(e){
	e.preventDefault();
	let timerInterval;
	Swal.fire({
		title: 'Please wait',
		html: 'Looking for data...',
		timer: 10000,
		timerProgressBar: true,
		didOpen: () => {
			Swal.showLoading()
			timerInterval = setInterval(() => {
				const content = Swal.getContent()
				if (content) {
					const b = content.querySelector('b')
					if (b) {
						b.textContent = Swal.getTimerLeft()
					}
				}
			}, 100)
		},
		willClose: () => {
			clearInterval(timerInterval);

		}
	}).then((result) => {
		/* Read more about handling dismissals below */
		if (result.dismiss === Swal.DismissReason.timer) {
			Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
		}
	});

	var value = $("#nama.penjualan-ajax").val(), parent = $(this).closest("fieldset");

	$.post("public/Api/getAssetByName", { id: value })
		.done(function (data) {
			parent.find("fieldset").remove();
			parent.find("#barcode").val("");
			if (data) {
				data = JSON.parse(data);
				parent.find("#barcode").val(data.barcode);
				$("#harga").val(data.harga);
				$("#quantity").attr("max", data.stok);
				if ($("#quantity").val() > data.stok) $("#quantity").val(data.stok);
				$.post("public/Api/getAssetPenjualanViewBarcode", { id: data.barcode })
					.done(function (data2) {
						Swal.close();
						parent.append(data2);
						parent.find("#selectmethod").val("auto");
						timerInterval = setInterval(() => {
							$("#quantity").focus();
							clearInterval(timerInterval)
						}, 1000);
					});
			} else {
				parent.find("#selectmethod").val("manual");
				Notify("Data barang tidak ditemukan, pastikan nama yang kamu masukan sudah benar", ' Uppsss...', "error");
				Swal.close();
			}
		});

	return false;
});

$("#barcode.pembelian-ajax").on('keydown', function(e){
	if(e.key=="Enter"){
		e.preventDefault();
		let timerInterval;
		Swal.fire({
			title: 'Please wait',
			html: 'Looking for data...',
			timer: 10000,
			timerProgressBar: true,
			didOpen: () => {
				Swal.showLoading()
				timerInterval = setInterval(() => {
					const content = Swal.getContent()
					if (content) {
						const b = content.querySelector('b')
						if (b) {
							b.textContent = Swal.getTimerLeft()
						}
					}
				}, 100)
			},
			willClose: () => {
				clearInterval(timerInterval);
			}
		}).then((result) => {
			/* Read more about handling dismissals below */
			if (result.dismiss === Swal.DismissReason.timer) {
				Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
			}
		});

		var value = $(this).val(), parent = $(this).closest("fieldset");

		$.post("public/Api/getAssetByBarcode", { id: value })
			.done(function (data) {
				parent.find("fieldset").remove();
				parent.find("#nama").val("");
				$("#penjualan-add-batch").attr("disabled", "true");
				if (data) {
					data = JSON.parse(data);
					parent.find("#nama").val(data.nama);
					$("#harga").val(data.harga);
					$.post("public/Api/getAssetViewBarcode", { id: value })
						.done(function (data) {
							Swal.close();
							parent.append(data);
							parent.find("#selectmethod").val("auto");
							$("#penjualan-add-batch").removeAttr("disabled");
							timerInterval = setInterval(() => {
								$("#quantity").focus();
								clearInterval(timerInterval)
							}, 1000);
						});
				}else{
					$.get("public/Api/getAssetViewEmpty")
						.done(function (data) {
							Notify("Data barang tidak ditemukan, silahkan masukan rincian barang secara manual", ' Uppsss...', "warning");
							Swal.close();
							parent.append(data);
							parent.find("#nama").val("");
							parent.find("#selectmethod").val("manual");
							$("#penjualan-add-batch").attr("disabled", "true");
						});
				}
			});

		return false;
	}
});

$("#nama.pembelian-ajax").on('keydown', function(e){
	if (e.key == "Enter") {
		e.preventDefault();
		let timerInterval;
		Swal.fire({
			title: 'Please wait',
			html: 'Looking for data...',
			timer: 10000,
			timerProgressBar: true,
			didOpen: () => {
				Swal.showLoading()
				timerInterval = setInterval(() => {
					const content = Swal.getContent()
					if (content) {
						const b = content.querySelector('b')
						if (b) {
							b.textContent = Swal.getTimerLeft()
						}
					}
				}, 100)
			},
			willClose: () => {
				clearInterval(timerInterval);
			}
		}).then((result) => {
			/* Read more about handling dismissals below */
			if (result.dismiss === Swal.DismissReason.timer) {
				Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
			}
		});

		var value = $(this).val(), parent = $(this).closest("fieldset");

		$.post("public/Api/getAssetByName", { id: value })
			.done(function (data) {
				parent.find("fieldset").remove();
				parent.find("#barcode").val("");
				$("#penjualan-add-batch").attr("disabled", "true");
				if (data) {
					data = JSON.parse(data);
					parent.find("#barcode").val(data.barcode);
					$("#harga").val(data.harga);
					$.post("public/Api/getAssetViewBarcode", { id: data.barcode })
						.done(function (data2) {
							Swal.close();
							parent.append(data2);
							parent.find("#selectmethod").val("auto");
							$("#penjualan-add-batch").removeAttr("disabled");
							timerInterval = setInterval(() => {
								$("#quantity").focus();
								clearInterval(timerInterval);
							}, 1000);
						});
				} else {
					$.get("public/Api/getAssetViewEmpty")
						.done(function (data2) {
							Notify("Data barang tidak ditemukan, silahkan masukan rincian barang secara manual", ' Uppsss...', "warning");
							Swal.close();
							parent.append(data2);
							parent.find("#nama").val("");
							parent.find("#selectmethod").val("manual");
							$("#penjualan-add-batch").attr("disabled", "true");
						});
				}
			});

		return false;
	}
});

$("#barcode.penjualan-ajax").on('keydown', function (e) {
	if (e.key == "Enter") {
		e.preventDefault();
		let timerInterval;
		Swal.fire({
			title: 'Please wait',
			html: 'Looking for data...',
			timer: 10000,
			timerProgressBar: true,
			didOpen: () => {
				Swal.showLoading()
				timerInterval = setInterval(() => {
					const content = Swal.getContent()
					if (content) {
						const b = content.querySelector('b')
						if (b) {
							b.textContent = Swal.getTimerLeft()
						}
					}
				}, 100)
			},
			willClose: () => {
				clearInterval(timerInterval);
			}
		}).then((result) => {
			/* Read more about handling dismissals below */
			if (result.dismiss === Swal.DismissReason.timer) {
				Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
			}
		});

		var value = $(this).val(), parent = $(this).closest("fieldset");

		$.post("public/Api/getAssetByBarcode", { id: value })
			.done(function (data) {
				parent.find("fieldset").remove();
				parent.find("#nama").val("");
				$("#penjualan-add-batch").attr("disabled", "true");
				if (data) {
					data = JSON.parse(data);
					parent.find("#nama").val(data.nama);
					$("#harga").val(data.harga);
					$("#quantity").attr("max", data.stok);
					if ($("#quantity").val() > data.stok) $("#quantity").val(data.stok);
					$.post("public/Api/getAssetPenjualanViewBarcode", { id: value })
						.done(function (data2) {
							Swal.close();
							parent.append(data2);
							parent.find("#selectmethod").val("auto");
							$("#penjualan-add-batch").removeAttr("disabled");
							timerInterval = setInterval(() => {
								$("#quantity").focus();
								clearInterval(timerInterval)
							}, 1000);
						});
				} else {
					parent.find("#selectmethod").val("manual");
					Notify("Data barang tidak ditemukan, pastikan barcode yang kamu masukan sudah benar", ' Uppsss...', "error");
					$("#penjualan-add-batch").attr("disabled", "true");
					Swal.close();
				}
			});

		return false;
	}
});

$("#nama.penjualan-ajax").on('keydown', function (e) {
	if (e.key == "Enter") {
		e.preventDefault();
		let timerInterval;
		Swal.fire({
			title: 'Please wait',
			html: 'Looking for data...',
			timer: 10000,
			timerProgressBar: true,
			didOpen: () => {
				Swal.showLoading()
				timerInterval = setInterval(() => {
					const content = Swal.getContent()
					if (content) {
						const b = content.querySelector('b')
						if (b) {
							b.textContent = Swal.getTimerLeft()
						}
					}
				}, 100)
			},
			willClose: () => {
				clearInterval(timerInterval);

			}
		}).then((result) => {
			/* Read more about handling dismissals below */
			if (result.dismiss === Swal.DismissReason.timer) {
				Notify("Data barang tidak ditemukan, silahkan coba lagi", ' Uppsss...', "warning");
			}
		});

		var value = $(this).val(), parent = $(this).closest("fieldset");

		$.post("public/Api/getAssetByName", { id: value })
			.done(function (data) {
				parent.find("fieldset").remove();
				parent.find("#barcode").val("");
				$("#penjualan-add-batch").attr("disabled", "true");
				if (data) {
					data = JSON.parse(data);
					parent.find("#barcode").val(data.barcode);
					$("#harga").val(data.harga);
					$("#quantity").attr("max", data.stok);
					if ($("#quantity").val() > data.stok) $("#quantity").val(data.stok);
					$.post("public/Api/getAssetPenjualanViewBarcode", { id: data.barcode })
						.done(function (data2) {
							Swal.close();
							parent.append(data2);
							parent.find("#selectmethod").val("auto");
							$("#penjualan-add-batch").removeAttr("disabled");
							timerInterval = setInterval(() => {
								$("#quantity").focus();
								clearInterval(timerInterval)
							}, 1000);
						});
				} else {
					parent.find("#selectmethod").val("manual");
					Notify("Data barang tidak ditemukan, pastikan nama yang kamu masukan sudah benar", ' Uppsss...', "error");
					$("#penjualan-add-batch").attr("disabled", "true");
					Swal.close();
				}
			});

		return false;
	}
});

$("a.toggle-detail").click(function(e){
	e.preventDefault();
	if ($("#" + $(this).attr("data-toggle"))){
		if ($("#" + $(this).attr("data-toggle")).hasClass("d-none")){
			$(this).find("i").removeClass("fa-chevron-down");
			$(this).find("i").addClass("fa-chevron-up");
		} else {
			$(this).find("i").removeClass("fa-chevron-up");
			$(this).find("i").addClass("fa-chevron-down");
		}
		$(this).find("i").toggleClass("text-success");
		$("#" + $(this).attr("data-toggle")).toggleClass("d-none");
		$(this).closest("tr").toggleClass("active selected table-dark");
	}
	return false;
});

$("#penjualan-add-batch").click(function(e){
	
	var obj = '<tr class="pbcr">';
	obj += '<td class="text-center"><span class="index-penjualan">0</span></td>';
	obj += '<td>';
	obj += '<input type="hidden" name="id_master[]" value="' + $("#id_master").val() + '">';
	obj += '<input type="text" class="form-control" disabled readonly value="' + $("#id_master").val() + '">';
	obj += '</td>';
	obj += '<td>';
	obj += '<input type="text" class="form-control" disabled readonly value="' + $("#barcode").val() + '">';
	obj += '</td>';
	obj += '<td>';
	obj += '<input type="text" class="form-control" disabled readonly value="' + $("#nama").val() + '">';
	obj += '</td>';
	obj += '<td>';
	obj += '<input type="number" class="form-control" min="1" name="quantity[]" max="' + $("#stok").val() + '" value="1" required="true" />';
	obj += '</td>';
	obj += '<td>';
	obj += '<input type="number" class="form-control" min="1" name="harga[]" value="' + $("#harga").val() + '" required="true" />';
	obj += '</td>';
	obj += '<td class="text-center">';
	obj += '<a href="#" class="btn btn-sm btn-warning" title="Hapus item" onclick="return removeMeRow(this)"><i class="fa fa-minus"></i></a>';
	obj += '</td>';
	obj += '</tr>';

	$("tbody").append(obj);

	$(this).closest("fieldset").find("fieldset").remove();
	$("#barcode").val("");
	$("#nama").val("");
	$(this).attr("disabled", "true");
	$("#barcode").focus();

	reCountPenjualan();
});

$("#penjualan-batch-validate").click(function(e){
	$('fieldset').find('fieldset').remove();
	$("#penjualan-add-batch").attr("disabled", "true");
	if($("#penjualan-batch-rows > tr").length == 0){
		alert("Silahkan tambahkan beberapa barang...");
		$("#barcode").focus();
		e.preventDefault();
		return false;
	}else{
		return true;
	}
});

function removeMeRow(obj){
	$(obj).closest("tr").remove();
	reCountPenjualan();
	return false;
}

function reCountPenjualan(){
	var index = 1;
	$("#penjualan-batch-rows > tr").each(function(){
		$(this).find(".index-penjualan").text(index++);
	})
}