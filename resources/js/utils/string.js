const preselect = (str, arr) => {
    if (arr.includes(str)) {
        return str;
    } else {
        let sub = arr.filter((item) => {
            item = item.toLowerCase().replace(/_/g, '');
            str = str.toLowerCase().replace(/_/g, '');

            return item.includes(str) || str.includes(item);
        });

        if (sub.length > 0) {
            return sub[0];
        }
    }

    return arr[0];
}

export { preselect };
