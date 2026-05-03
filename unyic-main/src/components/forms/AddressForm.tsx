import { useState } from "react";
import CheckboxField from "./shared/CheckboxField";
import EmailField from "./shared/EmailField";
import InputField from "./shared/InputField";
import { useForm, useWatch } from "react-hook-form";
import type { Address } from "../../types";
import clsx from "clsx";
import PhoneField from "./shared/PhoneField";
import SubmitButton from "./shared/SubmitButton";

const ADDRESS_TYPES = ["Home", "Office", "Others"] as const;

export type AddressFormData = Omit<Address, "id">;

interface AddressFormProps {
  action: "Add" | "Edit";
  isFormSubmitting: boolean;
  defaultValues?: AddressFormData;
  onSubmit: (data: AddressFormData) => void;
}

const AddressForm = ({
  defaultValues,
  onSubmit,
  action,
  isFormSubmitting,
}: AddressFormProps) => {
  const [isOthers, setIsOthers] = useState(
    action === "Edit"
      ? !["Home", "Office"].includes(defaultValues?.addressType ?? "")
      : false,
  );

  const {
    register,
    handleSubmit,
    formState: { errors },
    setValue,
    control,
  } = useForm<AddressFormData>({
    defaultValues: action === "Add" ? { addressType: "Home" } : defaultValues,
  });

  const selectedType = useWatch({ control, name: "addressType" });

  const handleAddressTypeSelect = (type: string) => {
    if (type === "Others") {
      setIsOthers(true);
      setValue("addressType", "");
    } else {
      setIsOthers(false);
      setValue("addressType", type, { shouldValidate: true });
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="max-h-[calc(100dvh-120px)] overflow-y-auto p-4 space-y-3">
        <InputField
          id="name"
          label="Full Name"
          type="text"
          placeholder="Enter your full name"
          registerProps={register("name", {
            required: "Full name is required",
          })}
          error={errors?.name}
        />

        <EmailField register={register} error={errors?.email} />

        <PhoneField register={register} error={errors?.phone} />

        <InputField
          id="address"
          label="Address Details"
          placeholder="Enter your address in details"
          error={errors?.address}
          registerProps={register("address", {
            required: "Detailed address is required",
          })}
        />

        {/* Address type selector with optional custom label input */}
        <div className="space-y-3">
          <label htmlFor="">Save Address As</label>

          <div className="mt-2 flex gap-2">
            {ADDRESS_TYPES.map((type) => (
              <button
                key={type}
                type="button"
                onClick={() => handleAddressTypeSelect(type)}
                className={clsx(
                  "w-full px-4 py-1 rounded border text-sm font-medium",
                  (isOthers ? type === "Others" : selectedType === type)
                    ? "bg-primary-dark text-light border-primary-dark"
                    : "bg-light text-dark-light border-gray-300",
                )}
              >
                {type}
              </button>
            ))}
          </div>

          {isOthers && (
            <InputField
              id="addressType"
              label=""
              placeholder="Save address as"
              error={errors?.addressType}
              registerProps={register("addressType", {
                required: "Address type is required",
              })}
            />
          )}
        </div>

        <CheckboxField
          id="isDefault"
          label="Make this my default Address"
          registerProps={register("isDefault")}
        />
      </div>

      <div className="h-15 px-4 py-2 border-t">
        <SubmitButton
          isLoading={isFormSubmitting}
          label={action === "Add" ? "Add Address" : "Update Address"}
          loadingLabel={
            action === "Add" ? "Adding Address..." : "Updating Address..."
          }
          className="text-sm uppercase"
        />
      </div>
    </form>
  );
};

export default AddressForm;
