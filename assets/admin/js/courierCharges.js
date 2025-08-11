$(document).ready(function () {
  var mode, JSON, res_DATA, charge_id;

  $.when(getCourierDetails()).done(function () {
    dispCourierDetails(JSON);
  });

  // function refreshDetails() {
  //   $.when(getCourierDetails()).done(function (brandDetails) {
  //     var table = $("#datatable").DataTable();
  //     table.clear();
  //     table.rows.add(brandDetails);
  //     table.draw();
  //     window.location.reload();
  //   });
  // }

  $("#addUserData").click(function () {
    mode = "new";
    $("#distric_modal").modal("show");
  });

  // Selecting Dist name based on State
  $("#state_id").change(function () {
    let state_id = $(this).val();
    if (mode == "new") {
      $.ajax({
        type: "POST",
        url: base_Url + "get-distfilr",
        data: { state_id: state_id },
        success: function (data) {
          var res = $.parseJSON(data);

          var Dist = "";

          for (let i = 0; i < res.length; i++) {
            Dist += `
            <option value="${res[i]["dist_id"]}">${res[i]["dist_name"]}</option>`;
          }
          $("#dist_id").html(`<option value="0">All District</option>` + Dist);
        },
      });
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "get-distfilr",
        data: { state_id: state_id },
        success: function (data) {
          var res = $.parseJSON(data);

          var Dist = "";

          Dist += `<option value="${distID}">${distname}</option>`;
          for (let i = 0; i < res.length; i++) {
            Dist += `<option value="${res[i]["dist_id"]}">${res[i]["dist_name"]}</option>`;
          }

          $("#dist_id").html(`<option value="0">All District</option>` + Dist);
        },
      });
    }
  });
  // *************************** [Validation] ********************************************************************

  function validation(message) {
    $.toast({
      icon: "error",
      heading: "Error",
      text: message,
      position: "top-right",
      bgColor: "#red",
      loader: true,
      hideAfter: 2000,
      stack: false,
      showHideTransition: "fade",
    });
  }

  $("#btn-submit").click(function () {
    if ($("#state_id").val() === "" && mode === "new") {
      validation("Please Select State");
    } else if ($("#dist_id").val() === "" && mode === "new") {
      validation("Please Select District");
    } else if ($("#courier_id").val() === "" && mode === "new") {
      validation("Please Select Courier");
    } else if ($("#charges").val() === "" && mode === "new") {
      validation("Please Enter courier charges");
    } else if ($("#active_sts").val() === "" && mode === "new") {
      validation("Please Select status");
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#modal-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "insert-charges";
    } else if (mode == "edit") {
      url = base_Url + "update-charges";
      data.append("charge_id", charge_id);
    }

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      processData: false,
      contentType: false,
      cache: false,

      success: function (data) {
        var convertData = $.parseJSON(data);
        if (convertData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: convertData["msg"],
            icon: "success",
          });
          $("#modal-form").empty();
          document.getElementById("modal-form").innerHTML = "";
          $("#distric_modal").modal("hide");

          getCourierDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: convertData["msg"],
            icon: "danger",
          });

          $("#distric_modal").modal("hide");
          getCourierDetails();
        }
      },
    });
  }

  // *************************** [get Data] *************************************************************************
  function getCourierDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "get-charges",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        dispCourierDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispCourierDetails(JSON) {
    var i = 1;
    $("#datatable").DataTable({
      destroy: true,
      aaSorting: [],
      aaData: JSON,
      aoColumns: [
        {
          mDataProp: null,
          render: function (data, type, row, meta) {
            return i++;
          },
        },
        {
          mDataProp: "state_title",
        },
        {
          mDataProp: "dist_name",
        },

        {
          mDataProp: "courier_name",
        },

        {
          mDataProp: "charges",
        },

        {
          mDataProp: function (data, type, full, meta) {
            var status = data.active_sts;
            let backgroundclr =
              status == 1 ? "badge bg-success" : "badge bg-danger";
            let sts = status == 1 ? "Active" : "Deactive";
            return (
              '<a id="' +
              meta.row +
              '" class="btn-Status btnSts"><span class="' +
              backgroundclr +
              '" charge-id="' +
              data.charge_id +
              '">' +
              sts +
              "</span></a>"
            );
          },
        },

        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a id="' +
              meta.row +
              '" class="btn btnEdit text-info fs-14 lh-1"> <i class="ri-edit-line"></i></a>' +
              '<a id="' +
              meta.row +
              '" class="btn BtnDelete text-danger fs-14 lh-1"> <i class="ri-delete-bin-5-line"></i></a>'
            );
          },
        },
      ],
    });
  }

  // *************************** [Activ/Deactive sts ] *************************************************************************

  $(".btn-Status").on("click", function () {
    alert("hii");
  });
  // *************************** [Edit Data] *************************************************************************

  var distID;
  var distname;
  $(document).on("click", ".btnEdit", function () {
    $("#distric_modal").modal("show");
    mode = "edit";

    var index = $(this).attr("id");

    var stateID = res_DATA[index].state_id;
    distID = res_DATA[index].dist_id;
    distname = res_DATA[index].dist_name;

    $("#state_id").val(stateID);
    $("#state_id").val(stateID).trigger("change");

    let charge = "";
    charge += `<option value="${res_DATA[index].courier_id}">
    ${res_DATA[index].courier_name}
</option>`;
    $("#courier_id").html(charge);

    $("#charges").val(res_DATA[index].charges);
    $("#comments").val(res_DATA[index].comments);

    $("#active_sts").val(res_DATA[index].active_sts);

    charge_id = res_DATA[index].charge_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");

    charge_id = res_DATA[index].charge_id;

    Swal.fire({
      title: "Are you sure?",
      text: "You want to delete it?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: base_Url + "delete-charge",
          data: { charge_id: charge_id },

          success: function (data) {
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });
              $("#model-data").modal("hide");
              refreshDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "danger",
              });
              $("#model-data").modal("hide");
              refreshDetails();
            }
          },
        });
      }
    });
  });
});
