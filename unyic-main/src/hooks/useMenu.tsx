import { useSelector } from "react-redux";
import type { RootState } from "../store/store";

const useMenu = () => {
  const { menu, isLoading } = useSelector((state: RootState) => state.menu);

  return {
    menu,
    isMenuLoading: isLoading,
  };
};

export default useMenu;
