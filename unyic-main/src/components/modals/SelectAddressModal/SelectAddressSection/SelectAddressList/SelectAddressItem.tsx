import {
  MdOutlineRadioButtonUnchecked,
  MdRadioButtonChecked,
} from "react-icons/md";
import AddressTypeIcon from "../../../../ui/AddressTypeIcon";
import type { Address } from "../../../../../types";
import useModalById from "../../../../../hooks/useModalById";

interface SelectAddressItemProps {
  item: Address;
  isSelected: boolean;
  onSelect: () => void;
}

const SelectAddressItem = ({
  item,
  isSelected,
  onSelect,
}: SelectAddressItemProps) => {
  const { openModalWithData: openUpdateModal } =
    useModalById("updateAddressModal");
  const { openModalWithData: openDeleteModal } = useModalById(
    "confirmDeleteAddressModal",
  );
  const { closeModal: closeSelectaAddressModal } =
    useModalById("selectAddressModal");

  const { id, name, addressType, isDefault, address } = item || {};

  const handleEdit = () => {
    closeSelectaAddressModal();
    openUpdateModal({ address: item });
  };

  const handleDelete = () => {
    closeSelectaAddressModal();
    openDeleteModal({ addressId: id });
  };

  return (
    <div key={id} className="p-3 pt-4 border rounded flex gap-3">
      <button onClick={onSelect} className="flex-none text-[22px] grid">
        {isSelected ? (
          <MdRadioButtonChecked className="text-primary" />
        ) : (
          <MdOutlineRadioButtonUnchecked className="text-primary-light" />
        )}
      </button>

      <div className="flex-1 text-sm">
        <div className="mt-0.50 flex items-center justify-between gap-3">
          <p className="flex items-center gap-2 text-dark-light">
            <AddressTypeIcon
              addressType={addressType}
              className="flex-none text-[17px]"
            />

            <span>{addressType}</span>
          </p>

          {isDefault && (
            <p className="px-3 py-0.50 rounded-full bg-primary text-light">
              Default
            </p>
          )}
        </div>

        <p className="mt-1.5 mb-0.5">{name}</p>
        <p className="text-xs">{address}</p>

        <div className="mt-2 flex items-center gap-3 text-dark-light">
          <button onClick={handleDelete}>Delete</button>
          <span>|</span>
          <button onClick={handleEdit}>Edit</button>
        </div>
      </div>
    </div>
  );
};

export default SelectAddressItem;
