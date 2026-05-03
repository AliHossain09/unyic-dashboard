import { createSlice, type PayloadAction } from "@reduxjs/toolkit";
import type { MenuItem } from "../../../types/menu";

interface MenuState {
  menu: MenuItem[];
  isLoading: boolean;
}

const initialState: MenuState = {
  menu: [],
  isLoading: false,
};

const menuSlice = createSlice({
  name: "menu",
  initialState,
  reducers: {
    setMenu: (state, { payload }: PayloadAction<MenuItem[]>) => {
      state.menu = payload;
    },

    setMenuLoading: (state, { payload }: PayloadAction<boolean>) => {
      state.isLoading = payload;
    },
  },
});

export const { setMenu, setMenuLoading } = menuSlice.actions;

export default menuSlice;
