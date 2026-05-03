import { useSelector } from "react-redux";
import type { RootState } from "../store/store";

const useUser = () => {
  const { user, isLoading, isUnfetched } = useSelector(
    (state: RootState) => state.user
  );

  return {
    user,
    isUserLoading: isLoading || isUnfetched,
  };
};

export default useUser;
