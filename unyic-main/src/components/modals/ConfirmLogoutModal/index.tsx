import { RiLoader4Line, RiLogoutBoxRLine } from "react-icons/ri";
import useModalById from "../../../hooks/useModalById";
import Button from "../../ui/Button";
import Modal from "../Modal";
import { useLogoutMutation } from "../../../store/features/auth/authApi";
import toast from "react-hot-toast";
import { useNavigate } from "react-router";

const ConfirmLogoutModal = () => {
  const { closeModal } = useModalById("confirmLogoutModal");
  const [logout, { isLoading }] = useLogoutMutation();
  const navigate = useNavigate();

  const handleLogout = async () => {
    try {
      await logout().unwrap();
      navigate("/");
    } catch (err) {
      console.error("Logout failed", err);
      toast.error("Logout failed");
    } finally {
      closeModal();
    }
  };

  return (
    <Modal
      modalId="confirmLogoutModal"
      containerClasses="max-w-sm w-[calc(100%-24px)] p-4 top-1/2 left-1/2 -translate-1/2"
      disableScroll={true}
    >
      <div className="space-y-3">
        <h2 className="text-lg font-semibold">Log out</h2>

        <p className="text-dark-light text-sm">
          Are you sure you want to log out of your account?
        </p>
      </div>

      {/* Action buttons */}
      <div className="mt-5 grid grid-cols-2 gap-4">
        <button
          className="px-4 py-2 bg-gray-200 rounded font-semibold"
          onClick={closeModal}
        >
          Cancel
        </button>

        <Button
          onClick={handleLogout}
          disabled={isLoading}
          className="max-w-40 flex items-center justify-center gap-2"
        >
          {isLoading ? (
            <>
              <RiLoader4Line size={20} className="animate-spin flex-none" />
              Logging out...
            </>
          ) : (
            <>
              <RiLogoutBoxRLine size={20} className="flex-none" />
              Log out
            </>
          )}
        </Button>
      </div>
    </Modal>
  );
};

export default ConfirmLogoutModal;
