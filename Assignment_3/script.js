document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById("input");
    const buttons = document.querySelectorAll("button");

    buttons.forEach(button => {
        button.addEventListener("click", function() {
            const value = this.value;

            if (value === "=") {
                try {
                    input.value = eval(input.value);
                } catch (e) {
                    input.value = "Error";
                }
            } else if (value === "C") {
                input.value = "";
            } else {
                input.value += value;
            }
        });
    });
});