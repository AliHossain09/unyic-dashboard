import { FaBriefcase, FaHome, FaMapMarkerAlt } from "react-icons/fa";

interface AddressTypeIconProps {
  addressType: string;
  className?: string;
}

const AddressTypeIcon = ({ addressType, className }: AddressTypeIconProps) => {
  const type = addressType?.toLowerCase();

  let Icon = FaMapMarkerAlt;

  if (type === "home") {
    Icon = FaHome;
  } else if (type === "office") {
    Icon = FaBriefcase;
  }

  return <Icon className={className} />;
};

export default AddressTypeIcon;
