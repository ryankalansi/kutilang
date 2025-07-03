const form = document.querySelector("form");
const submitButton = form.querySelector('button[type="submit"]');

form.addEventListener("submit", async (e) => {
  e.preventDefault();

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
    // GANTI URL INI!
    const response = await fetch(
      "http://localhost/kutilang/api/simpan-pendaftaran.php", // URL ke backend PHP Anda
      {
        method: "POST",
        // HAPUS 'mode: "no-cors"'
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      }
    );

    const result = await response.json(); // Sekarang kita bisa membaca respons dari server

    if (result.status === "success") {
      alert("Formulir berhasil dikirim! Kami akan menghubungi Anda segera.");
      form.reset();
    } else {
      throw new Error(result.message || "Terjadi kesalahan pada server.");
    }
  } catch (error) {
    console.error("Error:", error);
    alert(
      "Terjadi kesalahan saat mengirim formulir. Silakan coba lagi atau hubungi kami langsung.\n\nDetail: " +
        error.message
    );
  } finally {
    submitButton.disabled = false;
    submitButton.innerHTML =
      '<i class="bi bi-send me-2"></i>Kirim Formulir Pendaftaran';
  }
});
