const ff = {};

ff.text = (text, replacer = "-") => {
    try {
        if (!text) return replacer;
        if (text.length <= 0) return replacer;
        return text;
    } catch (error) {
        return replacer;
    }
};

ff.money = (val) => {
    try {
        if (!val) return 0;

        return new Intl.NumberFormat("th-TH", {
            style: "currency",
            currency: "THB",
        }).format(+val);
    } catch (error) {
        return 0;
    }
};

ff.number = (val) => {
    try {
        if (!val) return 0;

        return (+val).toLocaleString();
    } catch (error) {
        return 0;
    }
};

ff.dateandtime = (val) => {
    try {
        return new Intl.DateTimeFormat("th-TH", {
            timeZone: "Asia/Bangkok",
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        }).format(new Date(val));
    } catch (error) {
        return "-";
    }
};

ff.date = (val) => {
    try {
        return new Intl.DateTimeFormat("th-TH", {
            timeZone: "Asia/Bangkok",
            year: "numeric",
            month: "long",
            day: "numeric",
        }).format(new Date(val));
    } catch (error) {
        return "-";
    }
};

ff.role = (role) => {
    switch (role) {
        case 'admin':
            return `<span>แอดมิน</span>`
        case 'banned':
            return `<span>ระงับบัญชี</span>`
        default:
            return `<span>ผู้ใช้งาน</span>`
    }
}
