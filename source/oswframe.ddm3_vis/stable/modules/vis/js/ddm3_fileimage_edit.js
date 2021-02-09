var debug = false;

var scale = 0;
var scale_height = 0;
var scale_width = 0;

var height = 0;
var width = 0;
var aspect = 1;

var jcrop_api;
var option = '';
var imagecounter = 0;

var tmp_resize_height = null;
var tmp_resize_width = null;
var tmp_resize_aspect = null;

var tmp_crop_x = null;
var tmp_crop_y = null;
var tmp_crop_w = null;
var tmp_crop_h = null;

$(function () {
	if (debug === true) {
		console.log("init-start");
	}

	option = "init";

	/* SCALE */
	if (debug === true) {
		console.log("set scale functions");
	}
	$(".ddm3_popup_header_slider").slider({
		min: 10,
		max: 2000,
		value: 1000,
		slide: function (event, ui) {
			$(".ddm3_popup_header_slider_value").html("Zoom: " + ui.value / 10 + "%");
		},
		change: function (event, ui) {
			scale = ui.value;
			$("input[name=\'scale\']").val(scale);
			if (option == "crop") {
				tmp_crop_x = $("#crop_x").val();
				tmp_crop_y = $("#crop_y").val();
				tmp_crop_w = $("#crop_w").val();
				tmp_crop_h = $("#crop_h").val();
			}
			if (option != "init") {
				imagepreview("scale");
			}
		}
	});
	$(".ddm3_popup_header_100").click(function () {
		$(".ddm3_popup_header_slider").slider("option", "value", 1000);
	});
	$(".ddm3_popup_header_fit").click(function () {
		imagepreview("fit");
	});


	/* GENERAL */
	if (debug === true) {
		console.log("set general functions");
	}
	$(".ddm3_popup_navigation_list_overview .ddm3_popup_navigation_save").click(function () {
		if (parent.saved[ddm_group + "_" + ddm_element] == true) {

			$.ajax({
				url: image_url_view,
				async: false,
				data: {
					a: 'save'
				},
				type: "POST",
				success: function (data) {
					parent.saved[ddm_group + "_" + ddm_element] = false;
					parent.jQuery.fancybox.close();
				}
			});
		} else {
			parent.jQuery.fancybox.close();
		}
	});
	$(".ddm3_popup_navigation_list_overview .ddm3_popup_navigation_close").click(function () {
		parent.jQuery.fancybox.close();
	});

	/* RESIZE */
	if (debug === true) {
		console.log("set resize functions");
	}
	$(".ddm3_popup_navigation_list_overview .ddm3_popup_navigation_resize").click(function () {
		option = "resize";
		preload("resize", true);
	});
	$(".ddm3_popup_navigation_list_resize .ddm3_popup_navigation_save").click(function () {
		if (checkSize("resize") == true) {
			imagepreview("resize");
			afterload("resize");
			option = "";
		}
	});
	$(".ddm3_popup_navigation_list_resize .ddm3_popup_navigation_reset").click(function () {
		afterload("resize");
		preload("resize");
	});
	$(".ddm3_popup_navigation_list_resize .ddm3_popup_navigation_back").click(function () {
		afterload("resize", true);
		option = "";
	});
	/* 	RESIZE OPTIONS */
	$("#aspect").change(function () {
		if ($("#aspect").prop("checked") === false) {
			aspect = 0;
		} else {
			aspect = 1;
			$("#height").val(Math.round($("#width").val() / width * height));
		}
	});
	$("#width").change(function () {
		if (aspect == 1) {
			$("#height").val(Math.round($("#width").val() / width * height));
		}
	});
	$("#height").change(function () {
		if (aspect == 1) {
			$("#width").val(Math.round($("#height").val() / height * width));
		}
	});


	/* CROP */
	if (debug === true) {
		console.log("set crop functions");
	}
	$(".ddm3_popup_navigation_list_overview .ddm3_popup_navigation_crop").click(function () {
		option = "crop";
		preload("crop", true);
	});
	$(".ddm3_popup_navigation_list_crop .ddm3_popup_navigation_save").click(function () {
		if (checkSize("crop") == true) {
			imagepreview("crop");
			afterload("crop");
			option = "";
		}
	});
	$(".ddm3_popup_navigation_list_crop .ddm3_popup_navigation_reset").click(function () {
		afterload("crop");
		preload("crop");
	});
	$(".ddm3_popup_navigation_list_crop .ddm3_popup_navigation_back").click(function () {
		afterload("crop", true);
		option = "";
	});
	/* 	CROP OPTIONS */
	$("#crop_x").change(function () {
		if ((aspectRatio_x > 0) && (aspectRatio_y > 0)) {
			$("#crop_w").val($("#crop_w").val() - $("#crop_x").val());
			$("#_crop_x").val(Math.round(scale / 1000 * $("#crop_x").val()));
			$("#_crop_w").val(Math.round(scale / 1000 * $("#crop_w").val()));
		} else {
			$("#_crop_x").val(Math.round(scale / 1000 * $("#crop_x").val()));
		}
		jcrop_api.setSelect([$("#_crop_x").val(), $("#_crop_y").val(), parseFloat($("#_crop_x").val()) + parseFloat($("#_crop_w").val()), parseFloat($("#_crop_y").val()) + parseFloat($("#_crop_h").val())]);
	});
	$("#crop_y").change(function () {
		if ((aspectRatio_x > 0) && (aspectRatio_y > 0)) {
			$("#crop_h").val($("#crop_h").val() - $("#crop_y").val());
			$("#_crop_y").val(Math.round(scale / 1000 * $("#crop_y").val()));
			$("#_crop_h").val(Math.round(scale / 1000 * $("#crop_h").val()));
		} else {
			$("#_crop_y").val(Math.round(scale / 1000 * $("#crop_y").val()));
		}
		jcrop_api.setSelect([$("#_crop_x").val(), $("#_crop_y").val(), parseFloat($("#_crop_x").val()) + parseFloat($("#_crop_w").val()), parseFloat($("#_crop_y").val()) + parseFloat($("#_crop_h").val())]);
	});
	$("#crop_w").change(function () {
		if (debug === true) {
			console.log($("#crop_w").val() + '#' + $("#crop_h").val());
		}
		if ((aspectRatio_x > 0) && (aspectRatio_y > 0)) {
			$("#crop_h").val(Math.round(scale / 1000 * $("#crop_w").val()));
			$("#_crop_w").val(Math.round(scale / 1000 * $("#crop_w").val()));
			$("#_crop_h").val(Math.round(scale / 1000 * $("#crop_h").val()));
		} else {
			$("#_crop_w").val(Math.round(scale / 1000 * $("#crop_w").val()));
		}
		jcrop_api.setSelect([$("#_crop_x").val(), $("#_crop_y").val(), parseFloat($("#_crop_x").val()) + parseFloat($("#_crop_w").val()), parseFloat($("#_crop_y").val()) + parseFloat($("#_crop_h").val())]);
	});
	$("#crop_h").change(function () {
		if (debug === true) {
			console.log($("#crop_w").val() + '#' + $("#crop_h").val());
		}
		if ((aspectRatio_x > 0) && (aspectRatio_y > 0)) {
			$("#crop_w").val(Math.round(scale / 1000 * $("#crop_h").val()));
			$("#_crop_w").val(Math.round(scale / 1000 * $("#crop_w").val()));
			$("#_crop_h").val(Math.round(scale / 1000 * $("#crop_h").val()));
		} else {
			$("#_crop_h").val(Math.round(scale / 1000 * $("#crop_h").val()));
		}
		jcrop_api.setSelect([$("#_crop_x").val(), $("#_crop_y").val(), parseFloat($("#_crop_x").val()) + parseFloat($("#_crop_w").val()), parseFloat($("#_crop_y").val()) + parseFloat($("#_crop_h").val())]);
	});

	imagepreview("fit");

	option = "";

	if (debug === true) {
		console.log("init-end");
	}
	$('#loader').hide();
});

function updateCropCoords(c) {
	$("#_crop_x").val(c.x);
	$("#_crop_y").val(c.y);
	$("#_crop_w").val(c.w);
	$("#_crop_h").val(c.h);

	$("#crop_x").val(Math.round(1000 / scale * $("#_crop_x").val()));
	$("#crop_y").val(Math.round(1000 / scale * $("#_crop_y").val()));
	$("#crop_w").val(Math.round(1000 / scale * $("#_crop_w").val()));
	$("#crop_h").val(Math.round(1000 / scale * $("#_crop_h").val()));
};

function checkSize(a) {
	if (a == "resize") {
		if (typeof width_min !== 'undefined') {
			if ($("#width").val() < width_min) {
				alert("Das Bild ist zu klein.");
				return false;
			}
		}
		if (typeof height_min !== 'undefined') {
			if ($("#height").val() < height_min) {
				alert("Das Bild ist zu klein.");
				return false;
			}
		}

		if (typeof width_min !== 'undefined') {
			if ($("#width").val() > width_max) {
				alert("Das Bild ist zu groß.");
				return false;
			}
		}
		if (typeof height_min !== 'undefined') {
			if ($("#height").val() > height_max) {
				alert("Das Bild ist zu groß.");
				return false;
			}
		}
	}
	if (a == "crop") {
		if (typeof width_min !== 'undefined') {
			if ($("#crop_w").val() < width_min) {
				alert("Der Bildauschnitt ist zu klein.");
				return false;
			}
		}
		if (typeof height_min !== 'undefined') {
			if ($("#crop_h").val() < height_min) {
				alert("Der Bildauschnitt ist zu klein.");
				return false;
			}
		}

		if (typeof width_min !== 'undefined') {
			if ($("#crop_w").val() > width_max) {
				alert("Der Bildauschnitt ist zu groß.");
				return false;
			}
		}
		if (typeof height_min !== 'undefined') {
			if ($("#crop_h").val() > height_max) {
				alert("Der Bildauschnitt ist zu groß.");
				return false;
			}
		}
	}
	return true;
}

function preload(a, save) {
	if (debug === true) {
		console.log("call-start preload with " + a);
	}

	if (!save) {
		save = false;
	}

	if (a == "resize") {
		$.ajax({
			url: image_url_save,
			dataType: "json",
			async: false,
			data: {
				a: "getoptions"
			},
			type: "POST",
			success: function (data) {
				height = data.height;
				width = data.width;
			}
		});
		if ((tmp_resize_width != null) && (save == true)) {
			$("#width").val(tmp_resize_width);
		} else {
			$("#width").val(width);
		}
		if ((tmp_resize_height != null) && (save == true)) {
			$("#height").val(tmp_resize_height);
		} else {
			$("#height").val(height);
		}
		if ((tmp_resize_aspect != null) && (save == true)) {
			if (tmp_resize_aspect == 0) {
				$("#aspect").prop("checked", false);
			} else {
				$("#aspect").prop("checked", true);
			}
		} else {
			if (aspect == 0) {
				$("#aspect").prop("checked", false);
			} else {
				$("#aspect").prop("checked", true);
			}
		}
		$(".ddm3_popup_navigation_list_overview").fadeOut(0);
		$(".ddm3_popup_navigation_list_resize").fadeIn(0);
	}

	if (a == "crop") {
		$.ajax({
			url: image_url_save,
			dataType: "json",
			async: false,
			data: {
				a: "getoptions"
			},
			type: "POST",
			success: function (data) {
				scale = data.scale;
				scale_height = data.scale_height;
				scale_width = data.scale_width;
				height = data.height;
				width = data.width;
			}
		});

		if (debug === true) {
			console.log(tmp_crop_x + ' ' + tmp_crop_y + ' ' + tmp_crop_w + ' ' + tmp_crop_h + ' ' + save);
		}
		if ((tmp_crop_x != null) && (tmp_crop_y != null) && (tmp_crop_w != null) && (tmp_crop_h != null) && (save == true)) {
			x = Math.round(scale / 1000 * tmp_crop_x);
			y = Math.round(scale / 1000 * tmp_crop_y);
			w = Math.round(scale / 1000 * tmp_crop_w) + x;
			h = Math.round(scale / 1000 * tmp_crop_h) + y;
		} else {
			if ((aspectRatio_x > 0) && (aspectRatio_y > 0)) {
				if ((scale_width / scale_height) > (aspectRatio_x / aspectRatio_y)) {
					x = Math.round((scale_width - ((scale_height / aspectRatio_y) * aspectRatio_x)) * 0.5);
					y = 0;
					w = scale_width + x;
					h = scale_height;
				} else {
					x = 0;
					y = Math.round((scale_height - ((scale_width / aspectRatio_x) * aspectRatio_y)) * 0.5);
					w = scale_width;
					h = scale_height - y;
				}
			} else {
				x = 0;
				y = 0;
				w = scale_width;
				h = scale_height;
			}
		}

		$("#_crop_x").val(x);
		$("#_crop_y").val(y);
		$("#_crop_w").val(w);
		$("#_crop_h").val(h);

		if ((aspectRatio_x > 0) && (aspectRatio_y > 0)) {
			jcrop_api = $.Jcrop(".ddm3_popup_content_image img", {
				onSelect: updateCropCoords,
				aspectRatio: aspectRatio_x / aspectRatio_y,
				setSelect: [x, y, w, h]
			});
		} else {
			jcrop_api = $.Jcrop(".ddm3_popup_content_image img", {
				onSelect: updateCropCoords,
				setSelect: [x, y, w, h]
			});
		}

		$("#crop_x").val(Math.round(1000 / scale * $("#_crop_x").val()));
		$("#crop_y").val(Math.round(1000 / scale * $("#_crop_y").val()));
		$("#crop_w").val(Math.round(1000 / scale * $("#_crop_w").val()));
		$("#crop_h").val(Math.round(1000 / scale * $("#_crop_h").val()));


		$(".ddm3_popup_navigation_list_overview").fadeOut(0);
		$(".ddm3_popup_navigation_list_crop").fadeIn(0);
	}

	if (debug === true) {
		console.log("call-end preload with " + a);
	}
}

function afterload(a, save) {
	if (debug === true) {
		console.log("call-start afterload with " + a);
	}

	if (!save) {
		save = false;
	}

	if (a == "resize") {
		if (save === true) {
			tmp_resize_width = $("#width").val();
			tmp_resize_height = $("#height").val();
			if ($("#aspect").prop("checked") == true) {
				tmp_resize_aspect = 1;
			} else {
				tmp_resize_aspect = 0;
			}

		} else {
			aspect = 1;
		}
		$(".ddm3_popup_navigation_list_resize").fadeOut(0);
		$(".ddm3_popup_navigation_list_overview").fadeIn(0);
	}

	if (a == "crop") {
		if (save === true) {
			tmp_crop_x = $("#crop_x").val();
			tmp_crop_y = $("#crop_y").val();
			tmp_crop_w = $("#crop_w").val();
			tmp_crop_h = $("#crop_h").val();
		}

		if (jcrop_api) {
			jcrop_api.destroy();
		}
		$(".ddm3_popup_content_image img").css("width", "");
		$(".ddm3_popup_content_image img").css("height", "");
		$(".ddm3_popup_navigation_list_crop").fadeOut(0);
		$(".ddm3_popup_navigation_list_overview").fadeIn(0);
	}

	if (debug === true) {
		console.log("call-end afterload with " + a);
	}
}

function imagepreview(a) {
	$('#loader').show();

	if (debug === true) {
		console.log("call-start imagepreview with " + a);
	}

	if (a == "fit") {
		$.ajax({
			url: image_url_save,
			dataType: "json",
			async: false,
			data: {
				a: a
			},
			type: "POST",
			success: function (data) {
				if ($(".ddm3_popup_header_slider").slider("option", "value") != data.scale) {
					$(".ddm3_popup_header_slider").slider("option", "value", data.scale);
				}
				$(".ddm3_popup_header_slider_value").html("Zoom: " + data.scale / 10 + "%");
				scale = data.scale;
				scale_height = data.scale_height;
				scale_width = data.scale_width;

				imagecounter++;
				var img = $(".ddm3_popup_content_image img").attr('src', image_url_view + "&timestamp=" + imagecounter + new Date().getTime()).on('load', function () {
					$(".ddm3_popup_content_image").css("height", scale_height);
					$(".ddm3_popup_content_image").css("width", scale_width);
					if (option == "crop") {
						afterload("crop");
						preload("crop", true);
					}
				});
			}
		});
	}
	if (a == "scale") {
		$.ajax({
			url: image_url_save,
			dataType: "json",
			async: false,
			data: {
				a: a,
				scale: scale
			},
			type: "POST",
			success: function (data) {
				if ($(".ddm3_popup_header_slider").slider("option", "value") != data.scale) {
					$(".ddm3_popup_header_slider").slider("option", "value", data.scale);
				}
				$(".ddm3_popup_header_slider_value").html("Zoom: " + data.scale / 10 + "%");
				scale = data.scale;
				scale_height = data.scale_height;
				scale_width = data.scale_width;

				imagecounter++;
				var img = $(".ddm3_popup_content_image img").attr('src', image_url_view + "&timestamp=" + imagecounter + new Date().getTime()).on('load', function () {
					$(".ddm3_popup_content_image").css("height", scale_height);
					$(".ddm3_popup_content_image").css("width", scale_width);
					if (option == "crop") {
						afterload("crop");
						preload("crop", true);
					}
				});
			}
		});
	}
	if (a == "resize") {
		parent.saved[ddm_group + "_" + ddm_element] = true;
		$.ajax({
			url: image_url_save,
			dataType: "json",
			async: false,
			data: {
				a: a,
				width: $("#width").val(),
				height: $("#height").val()
			},
			type: "POST",
			success: function (data) {
				if ($(".ddm3_popup_header_slider").slider("option", "value") != data.scale) {
					$(".ddm3_popup_header_slider").slider("option", "value", data.scale);
				}
				$(".ddm3_popup_header_slider_value").html("Zoom: " + data.scale / 10 + "%");
				height = data.height;
				width = data.width;

				imagecounter++;
				var img = $(".ddm3_popup_content_image img").attr('src', image_url_view + "&timestamp=" + imagecounter + new Date().getTime()).on('load', function () {
					$(".ddm3_popup_content_image").css("height", scale_height);
					$(".ddm3_popup_content_image").css("width", scale_width);
					if (option == "crop") {
						afterload("crop");
						preload("crop", true);
					}
				});
			}
		});
	}
	if (a == "crop") {
		parent.saved[ddm_group + "_" + ddm_element] = true;
		$.ajax({
			url: image_url_save,
			dataType: "json",
			async: false,
			data: {
				a: a,
				crop_x: $("#crop_x").val(),
				crop_y: $("#crop_y").val(),
				crop_w: $("#crop_w").val(),
				crop_h: $("#crop_h").val(),
			},
			type: "POST",
			success: function (data) {
				if ($(".ddm3_popup_header_slider").slider("option", "value") != data.scale) {
					$(".ddm3_popup_header_slider").slider("option", "value", data.scale);
				}
				$(".ddm3_popup_header_slider_value").html("Zoom: " + data.scale / 10 + "%");
				height = data.height;
				width = data.width;

				imagecounter++;
				var img = $(".ddm3_popup_content_image img").attr('src', image_url_view + "&timestamp=" + imagecounter + new Date().getTime()).on('load', function () {
					$(".ddm3_popup_content_image").css("height", scale_height);
					$(".ddm3_popup_content_image").css("width", scale_width);
					if (option == "crop") {
						afterload("crop");
						preload("crop", true);
					}
				});
			}
		});
	}

	if (debug === true) {
		console.log("call-end imagepreview with " + a);
	}
}