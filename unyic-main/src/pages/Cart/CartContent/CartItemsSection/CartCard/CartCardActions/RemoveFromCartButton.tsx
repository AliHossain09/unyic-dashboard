import { RiDeleteBinLine } from "react-icons/ri";
import type { CartItem } from "../../../../../../types";
import useModalById from "../../../../../../hooks/useModalById";

interface RemoveFromCartButtonProps {
  cartItem: CartItem;
}

const RemoveFromCartButton = ({ cartItem }: RemoveFromCartButtonProps) => {
  const { openModalWithData } = useModalById("confirmCartDeleteModal");

  return (
    <button
      onClick={() => openModalWithData({cartItem})}
      className="p-2 flex-1 flex gap-1 items-center justify-center sm:uppercase"
    >
      <RiDeleteBinLine className="shrink-0 text-lg text-dark-light" />
      <span className="font-semibold sm:font-normal text-xs">Remove</span>
    </button>
  );
};

export default RemoveFromCartButton;
