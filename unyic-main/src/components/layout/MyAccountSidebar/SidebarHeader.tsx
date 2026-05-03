import useUser from "../../../hooks/useUser";

const getInitials = (name?: string) => {
  if (!name) {
    return "";
  }

  const words = name.trim().split(" ").filter(Boolean);

  if (words.length === 1) {
    return words[0][0].toUpperCase();
  }

  return (words[0][0] + words[words.length - 1][0]).toUpperCase();
};

const SidebarHeader = () => {
  const { user } = useUser();
  const { name, email } = user || {};

  const initials = getInitials(name);

  return (
    <div className="pb-5 border-b flex items-center gap-2.5">
      <div className="size-10 rounded-full bg-primary/20 grid place-content-center">
        <p className="text-primary-dark font-bold">{initials || "?"}</p>
      </div>

      <div>
        <p className="text-sm font-bold">{name}</p>
        <p className="-mt-0.75 text-xs text-dark-light font-semibold">
          {email}
        </p>
      </div>
    </div>
  );
};

export default SidebarHeader;
