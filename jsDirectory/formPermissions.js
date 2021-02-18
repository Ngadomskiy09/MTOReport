var perm = $("h1[class=disappear]").html();

console.log(perm);

switch (perm) {
    case "Ope":
        $(".ope").removeAttr("readonly");
        break;
    case "Lay":
        $(".lay").removeAttr("readonly");
        break;
    case "Tea":
        $(".tea").removeAttr("readonly");
        break;
}