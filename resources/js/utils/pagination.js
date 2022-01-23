const numberLinks = (currentpage, totalpages, visible) => {
  currentpage = currentpage || 1
  totalpages = totalpages || 1
  visible = visible || 1;

  let range = []

  if (totalpages > visible) {
    let vpages = visible - 2;

    range.push({ page: 1 })

    let startpage = currentpage - Math.floor((vpages - 1) / 2);

    if (startpage < 3) { startpage = 2 }

    if (startpage > (totalpages - 2)) { startpage = currentpage - Math.ceil((vpages - 1) / 2) }

    let endpage = startpage + (vpages - 1);

    if (endpage > (totalpages - 2)) {
      startpage = startpage - (endpage - totalpages) - 1
      endpage = totalpages - 1;
    }

    if (startpage > 2) {
      range.push({ page: null });
    }

    for (let i = startpage; i <= endpage; i++) {
      range.push({ page: i })
    }

    if (endpage < (totalpages - 1)) {
      range.push({ page: null })
    }

    range.push({ page: totalpages })
  } else {
    range = [...Array(totalpages).keys()].map(i => {
      return {
        page: i + 1
      }
    })
  }

  return range;
};

export { numberLinks };
