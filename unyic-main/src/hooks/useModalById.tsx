import { useDispatch, useSelector } from "react-redux";
import type { RootState } from "../store/store";
import type { ModalId, ModalsState } from "../types/modal";
import {
  closeModalById,
  openModalById,
} from "../store/features/modal/modalSlice";

const useModalById = <T extends ModalId>(modalId: T) => {
  const modal = useSelector((state: RootState) => state.modalsState[modalId]);
  const dispatch = useDispatch();

  const openModal = () => {
    dispatch(openModalById({ modalId, data: null }));
  };

  const openModalWithData = (data: ModalsState[T]["data"]) => {
    dispatch(openModalById({ modalId, data }));
  };

  const closeModal = () => dispatch(closeModalById(modalId));

  return {
    isModalOpen: modal.isOpen,
    modalData: modal.data as ModalsState[T]["data"],
    openModal,
    openModalWithData,
    closeModal,
  };
};

export default useModalById;
