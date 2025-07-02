const form = document.querySelector("form");
const submitButton = form.querySelector('button[type="submit"]');

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  // Disable submit button untuk mencegah double submit
  submitButton.disabled = true;
  submitButton.innerHTML =
    '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';

  const data = {
    childFullName: document.getElementById("childFullName").value,
    childDOB: document.getElementById("childDOB").value,
    childGender: document.getElementById("childGender").value,
    parentName: document.getElementById("parentName").value,
    parentEmail: document.getElementById("parentEmail").value,
    parentPhoneNumber: document.getElementById("parentPhoneNumber").value,
    address: document.getElementById("address").value,
    additionalInfo: document.getElementById("additionalInfo").value,
  };

  try {
    console.log("Mengirim data:", data); // Debug log

    const response = await fetch(
      "https://script.google.com/macros/s/AKfycbwzCegrn_pGgKHVOFu77LCsZuj1xI9Uf2VL2Dk9EcFnBH5I8xM2WApxnOi3szKn1DjcSw/exec",
      {
        method: "POST",
        mode: "no-cors", // Tambahkan ini untuk mengatasi CORS
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      }
    );

    // Karena menggunakan no-cors, kita tidak bisa membaca response
    // Jadi kita asumsikan berhasil jika tidak ada error
    alert("Formulir berhasil dikirim! Kami akan menghubungi Anda segera.");
    form.reset();
  } catch (error) {
    console.error("Error:", error);
    alert(
      "Terjadi kesalahan saat mengirim formulir. Silakan coba lagi atau hubungi kami langsung."
    );
  } finally {
    // Restore submit button
    submitButton.disabled = false;
    submitButton.innerHTML =
      '<i class="bi bi-send me-2"></i>Kirim Formulir Pendaftaran';
  }
});
