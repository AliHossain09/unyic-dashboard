import { createSlice, type PayloadAction } from "@reduxjs/toolkit";
import type { User } from "../../../types";

interface UserState {
  user: User | null;
  isLoading: boolean;
  isUnfetched?: boolean;
}

const initialState: UserState = {
  user: null,
  isLoading: false,
  isUnfetched: true,
};

const userSlice = createSlice({
  name: "user",
  initialState,
  reducers: {
    setUser: (state, { payload }: PayloadAction<User | null>) => {
      state.user = payload;
    },

    setUserLoading: (state, { payload }: PayloadAction<boolean>) => {
      state.isLoading = payload;
    },

    setUserUnfetched: (state, { payload }: PayloadAction<boolean>) => {
      state.isUnfetched = payload;
    },

    clearUser: (state) => {
      state.user = null;
      state.isLoading = false;
      state.isUnfetched = false;
    },
  },
});

export const { setUser, setUserLoading, setUserUnfetched, clearUser } =
  userSlice.actions;

export default userSlice;
