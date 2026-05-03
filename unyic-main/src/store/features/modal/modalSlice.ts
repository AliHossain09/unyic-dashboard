import { createSlice } from "@reduxjs/toolkit";
import type { PayloadAction } from "@reduxjs/toolkit";
import type { ModalId, ModalsState } from "../../../types/modal";

const initialState: ModalsState = {
  authModal: {
    isOpen: false,
    data: { activeTab: "login" },
  },

  forgotPasswordModal: {
    isOpen: false,
    data: null,
  },

  productSizeSelectorModal: {
    isOpen: false,
    data: null,
  },

  addAddressModal: {
    isOpen: false,
    data: null,
  },

  updateAddressModal: {
    isOpen: false,
    data: null,
  },

  selectAddressModal: {
    isOpen: false,
    data: null,
  },

  confirmCartDeleteModal: {
    isOpen: false,
    data: null,
  },

  confirmDeleteAddressModal: {
    isOpen: false,
    data: null,
  },

  confirmLogoutModal: {
    isOpen: false,
    data: null,
  },
};

const modalSlice = createSlice({
  name: "modalsState",
  initialState,
  reducers: {
    openModalById: <T extends ModalId>(
      state: ModalsState,
      {
        payload,
      }: PayloadAction<{
        modalId: T;
        data: ModalsState[T]["data"];
      }>,
    ) => {
      const { modalId, data } = payload;

      // Explicitly type the modal as ModalsState[T]
      const modal = {
        isOpen: true,
        data,
      } as ModalsState[T];

      state[modalId] = modal;
    },

    closeModalById: <T extends ModalId>(
      state: ModalsState,
      { payload }: PayloadAction<T>,
    ) => {
      state[payload] = initialState[payload];
    },
  },
});

export const { openModalById, closeModalById } = modalSlice.actions;

export default modalSlice;
