import useModalById from "./useModalById";
import useUser from "./useUser";

const useRequireAuth = () => {
  const { openModalWithData } = useModalById("authModal");
  const { user } = useUser();

  const requireAuth = (callback: () => void) => {
    if (!user) {
      openModalWithData({ activeTab: "login" });
      return;
    }

    callback();
  };

  return { requireAuth };
};

export default useRequireAuth;
