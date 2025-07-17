sap.ui.define([], () => {
  "use strict";

  return {
    formatting(sText, ...args) {
      return typeof sText === "string"
        ? sText.replace(/{(\d+)}/g, (match, i) =>
            typeof args[i] !== "undefined" ? args[i] : match
          )
        : "";

      // if (!sText) return "";
      // for (let i = 0; i < args.length; i++) {
      //   sText = sText.replaceAll(`{${i}}`, args[i]);
      // }
      // return sText;
    },
  };
});
