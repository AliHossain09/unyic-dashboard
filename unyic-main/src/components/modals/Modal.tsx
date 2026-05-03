import { IoClose } from "react-icons/io5";
import useModalById from "../../hooks/useModalById";
import type { ModalId } from "../../types/modal";
import { useEffect } from "react";
import clsx from "clsx";

interface ModalProps {
  modalId: ModalId;
  children: React.ReactNode;
  containerClasses?: string;
  closeOnOutsideClick?: boolean;
  disableScroll?: boolean;
}

const Modal = ({ modalId, containerClasses, children }: ModalProps) => {
  const { isModalOpen, closeModal } = useModalById(modalId);

  useEffect(() => {
    // Disable body scroll if modal is open
    if (isModalOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }

    return () => {
      document.body.style.overflow = ""; // Ensure cleanup to avoid side effects
    };
  }, [isModalOpen]);

  if (!isModalOpen) {
    return null;
  }

  return (
    <div className="fixed z-50 inset-0">
      {/* Overlay */}
      <div onClick={closeModal} className="absolute inset-0 bg-dark-light/70" />

      <div
        className={clsx(
          "absolute bg-light max-h-screen overflow-y-auto",
          containerClasses
        )}
      >
        <button
          className="absolute top-3 right-3 text-2xl"
          onClick={closeModal}
        >
          <IoClose />
        </button>

        {children}
      </div>
    </div>
  );
};

export default Modal;
