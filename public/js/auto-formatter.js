const __executeAutoFormatter = () => {
    const elements = $("[data-format]");

    elements.map((index) => {
        const element = $(elements[index]);
        const formatType = element.attr("data-format");
        const formatValue = element.attr("data-value");
        if (ff[formatType]) {
            element.html(ff[formatType]( formatValue || element.html()));
        } else {
            console.error("not found formatter : " + formatType);
        }
    });

    const suffix = $("[data-suffix]");

    elements.map((index) => {
        const element = $(elements[index]);
        element.html(
            element.html() + " " + (element.attr("data-suffix") || "")
        );
    });
}

$(document).ready(__executeAutoFormatter);
