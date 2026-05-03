import { FiEdit, FiTrash2 } from "react-icons/fi";
import type { Address } from "../../../../../types";
import useModalById from "../../../../../hooks/useModalById";
import AddressTypeIcon from "../../../../../components/ui/AddressTypeIcon";

interface AddressCardProps {
  address: Address;
}

const AddressCard = ({ address }: AddressCardProps) => {
  const { openModalWithData: openUpdateModal } =
    useModalById("updateAddressModal");
  const { openModalWithData: openDeleteModal } = useModalById(
    "confirmDeleteAddressModal",
  );

  const {
    id,
    addressType,
    isDefault,
    name,
    address: fullAddress,
    phone,
    email,
  } = address || {};

  return (
    <article className="border rounded-lg bg-light">
      <div className="p-4 pb-3 flex items-center justify-between gap-3">
        <div className="flex items-center gap-3">
          <div className="flex items-center gap-3">
            <AddressTypeIcon
              addressType={addressType}
              className="text-dark-light"
            />

            <div className="font-bold text-sm capitalize">{addressType}</div>
          </div>

          {isDefault && (
            <span className="px-3 py-0.75 rounded-full bg-primary/20 text-xs text-primary-dark font-semibold">
              Default
            </span>
          )}
        </div>

        <div className="flex items-center gap-3 text-dark-light">
          {/* Edit button */}
          <button
            onClick={() => {
              openUpdateModal({ address });
            }}
            className="size-6 grid place-items-center"
          >
            <FiEdit size={18} />
          </button>

          {/* Delete button */}
          <button
            onClick={() => {
              openDeleteModal({ addressId: id });
            }}
            className="size-6 grid place-items-center"
          >
            <FiTrash2 size={18} />
          </button>
        </div>
      </div>

      <div className="px-4 py-3 border-t text-sm space-y-3">
        <div className="space-y-px">
          <p className="text-xs font-semibold uppercase text-dark-light">
            Name
          </p>
          <p>{name}</p>
        </div>
        <div className="space-y-px">
          <p className="text-xs font-semibold uppercase text-dark-light">
            Address
          </p>
          <p>{fullAddress}</p>
        </div>
        <div className="space-y-px">
          <p className="text-xs font-semibold uppercase text-dark-light">
            Phone
          </p>
          <p>{phone}</p>
        </div>
        <div className="space-y-px">
          <p className="text-xs font-semibold uppercase text-dark-light">
            Email
          </p>
          <p>{email}</p>
        </div>
      </div>
    </article>
  );
};

export default AddressCard;
