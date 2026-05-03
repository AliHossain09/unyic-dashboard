import type { IconType } from "react-icons/lib";

interface IconBadgeProps {
  Icon: IconType;
  count?: number;
}

const IconBadge = ({ Icon, count = 0 }: IconBadgeProps) => {
  return (
    <div className="relative">
      <Icon />

      {count > 0 && (
        <span className="w-4 h-4 p-2 mt-7 border border-white rounded-full absolute -bottom-2 left-2 flex items-center justify-center bg-primary text-white text-xs">
          {count}
        </span>
      )}
    </div>
  );
};

export default IconBadge;
