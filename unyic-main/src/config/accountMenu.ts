import { LuPackage, LuFileText, LuMapPinned, LuKeyRound } from "react-icons/lu";

export const accountMenuItems = [
  {
    label: "My Orders",
    href: "/my-account/orders",
    Icon: LuPackage,
  },
  {
    label: "Saved Address",
    href: "/my-account/addresses",
    Icon: LuMapPinned,
  },
  {
    label: "Profile Details",
    href: "/my-account/info",
    Icon: LuFileText,
  },
  {
    label: "Change Password",
    href: "/my-account/change-password",
    Icon: LuKeyRound,
  },
];
