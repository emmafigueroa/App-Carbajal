var btn_print = document.querySelector("#btn_print");

const student = document.querySelector('#name').innerHTML;

function printReport(report) {
  var settings =
    "menubay=yes,location=yes,resizable=yes,scrollbar=yes,status=yes";

  var print = window.open(" ", "Boleta: " + student, settings);
  print.document.write("<html>");
  print.document.write(
    "<head><title>" + "Boleta: " + student + "</title></head>"
  );
  print.document.write("<body>");
  print.document.write(report.innerHTML);
  print.document.write("</body>");
  print.document.write("</html>");
  print.document.close();
  print.focus();
  print.onload = function() {
    print.print();
    print.close();

  };
  return true;
}

btn_print.addEventListener("click", () => {
  var section = document.querySelector("#show-report-card");
  printReport(section);
});
