sap.ui.define(
  [
    "sap/ui/core/mvc/Controller",
    "sap/m/MessageToast",
    "project_d/model/Helpers",
  ],
  (Controller, MessageToast, Helpers) => {
    "use strict";

    return Controller.extend("project_d.controller.HelloPanel", {
      onInit() {
        this.oDialog = null;

        // How to use directly in Controller
        // console.log(Helpers.formatting("Hello, {0}!", "New World"));
      },
      onShowHello() {
        const oView = this.getView();
        const oData = oView.getModel();
        const oBundl = oView.getModel("i18n").getResourceBundle();

        const sRecipientName = oData.getProperty("/recipient/name");
        const sMsg = oBundl.getText("buttonTextsMsg", [sRecipientName]);

        MessageToast.show(sMsg);
      },
      formatting(a, ...b) {
        return Helpers.formatting(a, ...b);
      },

      async onOpenDialog() {
        this.oDialog ??= await this.loadFragment({
          name: "project_d.view.HelloDialog",
        });

        this.oDialog.open();
      },
      onCloseDialog() {
        this.byId("helloDialog").close();
      },
    });
  }
);
