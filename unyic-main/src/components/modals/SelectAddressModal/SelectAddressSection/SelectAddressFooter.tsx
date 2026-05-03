import toast from "react-hot-toast";
import { useSetSelectedAddressMutation } from "../../../../store/features/address/addressApi";
import type { Id } from "../../../../types";
import Button from "../../../ui/Button";
import useModalById from "../../../../hooks/useModalById";

interface SelectAddressFooterProps {
  selectedAddressId: Id | null;
}

const SelectAddressFooter = ({
  selectedAddressId,
}: SelectAddressFooterProps) => {
  const { closeModal } = useModalById("selectAddressModal");

  const [changeSelectedAddress, { isLoading }] =
    useSetSelectedAddressMutation();

  const handleChangeAddress = async () => {
    if (!selectedAddressId || isLoading) {
      return;
    }

    try {
      await changeSelectedAddress(selectedAddressId).unwrap();
      toast.success("Delivery address updated");
    } catch (error) {
      toast.error("Failed to change delivery address");
      console.error("Failed to change delivery address :", error);
    } finally {
      closeModal();
    }
  };

  return (
    <div className="h-15 px-4 py-2 border-t">
      <Button onClick={handleChangeAddress} disabled={isLoading}>
        {isLoading ? "Changing..." : "Change Delivery Address"}
      </Button>
    </div>
  );
};

export default SelectAddressFooter;
