const host = "https://provinces.open-api.vn/api/";

// Gọi API để tải danh sách tỉnh/thành phố
const callAPI = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data, "province");
        })
        .catch((error) => {
            console.error("Error loading provinces:", error);
            alert("Có lỗi khi tải thông tin tỉnh/thành phố.");
        });
};

// Gọi API để tải danh sách quận/huyện
const callApiDistrict = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.districts, "district");
        })
        .catch((error) => {
            console.error("Error loading districts:", error);
            alert("Có lỗi khi tải thông tin quận/huyện.");
        });
};

// Gọi API để tải danh sách phường/xã
const callApiWard = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.wards, "ward");
        })
        .catch((error) => {
            console.error("Error loading wards:", error);
            alert("Có lỗi khi tải thông tin phường/xã.");
        });
};

// Hàm để hiển thị dữ liệu vào dropdown
const renderData = (array, select) => {
    let row = '<option disabled selected value="">Chọn</option>';
    array.forEach(element => {
        row += `<option value="${element.code}">${element.name}</option>`;
    });
    const selectElement = document.getElementById(select);
    selectElement.innerHTML = row;
    selectElement.disabled = false; // Kích hoạt dropdown khi có dữ liệu
    updateFullAddress(); // Cập nhật địa chỉ đầy đủ ngay sau khi dữ liệu được tải
};

// Sự kiện khi chọn tỉnh/thành phố
document.getElementById("province").addEventListener("change", function() {
    callApiDistrict(host + "p/" + this.value + "?depth=2");
    document.getElementById("district").disabled = true; // Vô hiệu hóa dropdown quận/huyện
    document.getElementById("ward").disabled = true; // Vô hiệu hóa dropdown phường/xã
});

// Sự kiện khi chọn quận/huyện
document.getElementById("district").addEventListener("change", function() {
    callApiWard(host + "d/" + this.value + "?depth=2");
    document.getElementById("ward").disabled = true; // Vô hiệu hóa dropdown phường/xã
});

// Sự kiện khi chọn phường/xã
document.getElementById("ward").addEventListener("change", function() {
    updateFullAddress(); // Cập nhật địa chỉ đầy đủ
});

// Tải danh sách tỉnh/thành phố khi trang được tải
callAPI(host + "?depth=1");

// Hàm để cập nhật địa chỉ đầy đủ
function updateFullAddress() {
    const streetname = document.getElementById("Streetname").value;
    const province = document.getElementById("province");
    const district = document.getElementById("district");
    const ward = document.getElementById("ward");
    
    let fullAddress = streetname;
    
    if (ward.selectedIndex > 0) {
        fullAddress += ", " + ward.options[ward.selectedIndex].text;
    }
    if (district.selectedIndex > 0) {
        fullAddress += ", " + district.options[district.selectedIndex].text;
    }
    if (province.selectedIndex > 0) {
        fullAddress += ", " + province.options[province.selectedIndex].text;
    }
    
    document.getElementById("fullAddress").value = fullAddress;
}

// Sửa đổi các sự kiện lắng nghe để gọi updateFullAddress()
document.getElementById("Streetname").addEventListener("input", updateFullAddress);


